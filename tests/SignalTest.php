<?php

use Inmanturbo\Signal\EventWithData;
use Inmanturbo\Signal\Facades\CommandBus;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot;
use Spatie\LaravelData\Data;

it('can add item to cart', function (): void {
    $product = new Product(
        '123',
        2,
        100,
    );

    CommandBus::dispatch(new AddCartItem(
        'fake-uuid',
        'fake-uuid2',
        $product,
    ));

    CommandBus::dispatch(new AddCartItem(
        'fake-uuid',
        'fake-uuid3',
        $product,
    ));

    $cart = CartAggregateRoot::retrieve('fake-uuid');

    $cart->snapshot();

    CommandBus::dispatch(AddCartItem::from([
        'cartUuid' => 'fake-uuid',
        'cartItemUuid' => 'fake-uuid4',
        'product' => $product,
    ]));

    $cart = CartAggregateRoot::retrieve('fake-uuid');

    expect($cart->total)->toBe(600);
    expect(count($cart->cartItems))->toBe(3);
    expect(EloquentSnapshot::count())->toBe(1);
});

class Product extends Data
{
    public function __construct(
        public string $sku,
        public int $quantity,
        public int $price,
    ) {}
}

class CartItemAdded extends EventWithData
{
    public function __construct(
        #[AggregateUuid]
        public string $cartUuid,
        public string $cartItemUuid,
        public Product $product,
    ) {}
}

#[HandledBy(CartAggregateRoot::class)]
class AddCartItem extends CartItemAdded
{
    //
}

class CartAggregateRoot extends AggregateRoot
{
    public $total;

    public array $cartItems;

    public function addItem(
        AddCartItem $addCartItem
    ): self {

        $this->recordThat(
            CartItemAdded::from($addCartItem->toArray()),
        );

        return $this;
    }

    public function applyAddItem(CartItemAdded $event)
    {
        $this->total += $amount = ($event->product->quantity * $event->product->price);

        $this->cartItems[] = (object) [
            'uuid' => $event->cartItemUuid,
            'product' => $event->product,
            'amount' => $amount,
        ];
    }
}
