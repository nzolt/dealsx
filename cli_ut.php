<?php
require_once 'class/deal.php';
require_once 'PHPUnit/Autoload.php';

/**
 * Test Class for Deal 
 */
class dealTest extends PHPUnit_Framework_TestCase {

    protected $dealer;
    protected $originalDeck;
    protected $shuffledDeck;

    public function __construct() {
        parent::__construct();
        $this->dealer = new Deal();
		$this->dealer->generateDeck();
        $this->originalDeck = $this->dealer->_deck;
    }
    
    public function testDealClass() {
        $this->assertMethodExist($this->dealer, 'dealCards');
        $this->assertMethodExist($this->dealer, 'dealHand');
        $this->assertMethodExist($this->dealer, 'generateDeck');
        $this->assertMethodExist($this->dealer, 'getCardtypes');
        $this->assertMethodExist($this->dealer, 'getCards');
        $this->assertMethodExist($this->dealer, 'printCards');
        $this->assertMethodExist($this->dealer, 'shuffleCards');
    }
        
    public function testDeckNr() {
        $this->assertCount( 52, $this->dealer->_deck);
    }
    
    public function testShuffle() {
        $this->dealer->shuffleCards();
		$this->shuffledDeck = $this->dealer->_deck;
        $deckDiff = array_diff($this->originalDeck, $this->shuffledDeck);
        $this->assertCount(0, $deckDiff);
        $deckIs = array_intersect($this->originalDeck, $this->shuffledDeck);
        $this->assertCount(52, $deckIs);
        $this->assertFalse(
                implode(' ', $this->originalDeck) ===  
                implode(' ', $this->shuffledDeck)
                );
    }
    
    public function testDeal() {
        $this->dealer->dealCards();
        $hands = $this->dealer->_hands;
        $this->assertCount(4, $hands);
        $dealerDeck = $this->dealer->_deck;
        foreach ($hands as $hand) {
            $this->assertCount(7, $hand);
            $this->assertCount(0, array_intersect($hand, $dealerDeck));
        }
        $this->assertCount(24, $this->dealer->_deck);
    }

    /**
    * Assert that a class has a method 
    *
    * @param string $class name of the class
    * @param string $method name of the searched method
    * @throws ReflectionException if $class don't exist
    * @throws PHPUnit_Framework_ExpectationFailedException if a method isn't found
    */
   protected function assertMethodExist($class, $method) {
       $oReflectionClass = new ReflectionClass($class); 
       $this->assertTrue($oReflectionClass->hasMethod($method));
   }
    
}
