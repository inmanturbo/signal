<?php

use Inmanturbo\Signal\Facades\CommandBus;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

it('can add item to cart', function () {
    $product = new Product(
        '123',
        1,
        1,
    );

    CommandBus::dispatch(new AddCartItem(
        'fake-uuid',
        'fake-uuid2',
        $product,
        100,
    ));

    CommandBus::dispatch(new AddCartItem(
        'fake-uuid',
        'fake-uuid3',
        $product,
        100,
    ));

    $cart = CartAggregateRoot::retrieve('fake-uuid');

    expect($cart->amount)->toBe(200);
    expect(count($cart->cartItems))->toBe(2);
});

class Product
{
    public function __construct(
        public string $sku,
        public int $quantity,
        public int $price,
    )
    {}
}

class CartItemAdded extends ShouldBeStored
{
    public function __construct(
        public string $aggregateUuid,
        public string $cartItemUuid,
        public Product $product,
        public int $amount,
    )
    {
    }
}

#[HandledBy(CartAggregateRoot::class)]
class AddCartItem
{
    public function __construct(
        #[AggregateUuid] 
        public string $cartUuid,
        public string $cartItemUuid,
        public Product $product,
        public int $amount,
    ) {
    }
}

class CartAggregateRoot extends AggregateRoot
{
    public $amount;

    public array $cartItems;

    public function addItem(
        AddCartItem $addCartItem
    ): self {
        
        $this->recordThat(
            new CartItemAdded(
                $this->uuid(),
                $addCartItem->cartItemUuid,
                $addCartItem->product,
                $addCartItem->amount,
            )
        );

        return $this;
    }

    public function applyAddItem(CartItemAdded $event)
    {
        $this->amount += $event->amount;

        $this->cartItems[] = (object) [
            'uuid' => $event->cartItemUuid,
            'product' => $event->product,
            'amount' => $event->amount,
        ];
    }
}


