<?php

class Card
{  //Im not concerned with the HTML card rendering so I don't think i need this class
    protected $allowedSuites = array('D', 'S', 'C', 'H');
    protected $rank;
    protected $suite;
    protected $color;
    protected $icon;

    public function __construct($rank, $suite)
    {
        if (!in_array($suite, $this->allowedSuites)) {
            throw new Exception("Can't create a card because suite doesn't exist: " . $suite);
        }
        $this->rank = $rank;
        $this->suite = $suite;

        $this->assignColor();
        $this->assignIcon();
    }

    public function assignColor()
    {
        $this->color = in_array($this->suite, array('D', 'H')) ? "Red" : "Black";
    }

    public function assignIcon()
    {
        switch ($this->suite) {
            case 'D':
                $this->icon = '&diams;';
                break;
            case 'H':
                $this->icon = '&hearts;';
                break;
            case 'S':
                $this->icon = '&spades;';
                break;
            case 'C':
                $this->icon = '&clubs;';
        }
    }

    public function render()
    {
        return '<span style= "color: ' . $this->color . '; border: 1px solid' . $this->color . ';">'
        . $this->rank
        . $this->icon
        . '</span>';
    }
}

class Player
{
    protected $name;
    protected $hand = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function giveCard(Card $Card)
    {  // ??? what is happening here?
        $this->hand[] = $Card;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getHand()
    {
        return $this->hand;
    }

}

class Deck
{
    protected $deck = [];
    protected $suites = array('H', 'S', 'C', 'D');
    protected $ranks = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'];

    public function __construct()
    {
        $this->createDeck();
        $this->shuffleDeck();
    }

    public function createDeck()
    {
        foreach ($this->suites as $suite) {
            foreach ($this->ranks as $rank) {
                $this->deck[] = new Card($rank, $suite);
            }
        }
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }

    /**
     * Get all cards in the deck
     * @return deck[]
     */
    public function getCards()
    {
        return $this->deck;
    }

    /**
     * Get one card from the deck, and decrement appropriately.
     * @throws exception
     * @return Card
     */
    public function getCard()
    {
        $this->shuffleDeck();
        //take it off the end, array_shift() takes from the front
        $card = array_pop($this->deck);
        if (empty($card)) {
            throw new Exception('I ran out of cards!');
        }
        return $card;
    }

    public function getNumCards()
    {
        return count($this->deck);
    }
}

class Game
{

    protected $playerNames = [];
    /**
     * Typehints are the class level
     * @var Player[]
     */
    protected $players = [];
    protected $numCardsPerPlayer;
    protected $deck;

    public function __construct($numCardsPerPlayer, $playerNames)
    {
        $this->numCardsPerPlayer = $numCardsPerPlayer;
        $this->deck = new Deck();
        $this->playerNames = $playerNames;
        $this->createPlayers();
        $this->deal();
    }

    public function createPlayers()
    {
        foreach ($this->playerNames as $player) {
            $this->players[] = new Player($player);
        }
    }

    public function deal()
    {
        foreach ($this->players as $player) {
            for ($i = 0; $i < $this->numCardsPerPlayer; $i++) {
                $card= $this->deck->getCard();
//                var_dump($card);
//                die();
                $player->giveCard($card);
            }
        }
    }

    public function render(){
        foreach($this->players as $player){
            echo $player->getName()."<br/>";
            $hand= $player->getHand();
            foreach($hand as $card){
                echo $card->render();
            }
            echo "<br/>";
        }
    }
}

$people = ['Pat', 'Nick', 'Taylor'];
$x = new Game(5, $people);
$x->render();
//print_r($x);
