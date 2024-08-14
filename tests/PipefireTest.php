<?php

use Illuminate\Support\Facades\Event;
use Inmanturbo\FunctionalLibrary\HasFunctionalLibrary;
use Inmanturbo\Signal\CommandHandler;

beforeEach(function () {
    // Event::listen(BillEvent::ItemAdded, function (Bill $bill, BillItem $billItem) {
    //     dump($bill, $billItem);
    // });
    // Event::listen(BillEvent::Posted->name, function ($payload) {
    //     // dump($payload, BillEvent::Posted->name);
    // });
});

it('can test', function () {
    Event::fake();

    Bills::closures()['bills_command_handler'](
        BillCommand::Post,
        new Bill(Posted::No, 'no items', 10.00, 0.00, 0.00),
    );

    Event::assertDispatched(BillEvent::Posted->name);
});

Class Bills
{
    use HasFunctionalLibrary;

    public static function library($bills_command_handler = false )
    {
        return static::getLibrary($bills_command_handler);
    }

    public static function closures()
    {
        return [
            'bills_command_handler' => function (BillCommand $message, Bill $bill) {
                return (new CommandHandler())(state: $bill, command: $message, event: match($message){
                    BillCommand::AddItem => BillEvent::ItemAdded,
                    default => null,
                });
            },
        ];
    }
}


enum BillCommand
{
    case AddItem;
    case RemoveItem;
    case Post;
}

enum BillEvent
{
   case ItemAdded;
   case ItemRemoved;
   case Posted;
}


class Bill 
{
    public function __construct(
        public BillState $state,
        public $items,
    ){}
}

class BillState
{
    public function __construct(
        public string $aggregate_id,
        public float $total,
        public float $credits,
        public float $balance,
        public Posted $posted,
    ){}
}

enum Posted
{
    case Yes;
    case No;
}

class BillItem
{
    public function __construct(
        public Bill $bill,
        public int $quantity,
        public string $unit,
        public float $price,
        public float $amount,

    ){}
}