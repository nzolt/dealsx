<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deal
 * @mail nzolt@dotweb.hu
 * @author Zoltan Nagy
 */
require_once 'dealexception.php';

class Deal {

	public $_deck = array();
    public $_hands = array();
    protected $_players = array('Player 1', 'Player 2', 'Player 3', 'Player 4');

	public function __construct($deal = FALSE, $print = FALSE) {        
        try {
            ($deal) ? $this->dealCards($print) : '';
        } catch (DealException $exc) {
            echo 'Sorry can\'t deal';
        } catch (Exception $exc){
            echo 'The Desk is closed';
        }
    }
    
    /**
     * We will shuffle the deck
     * @return \deal
     */
    public function shuffleCards() {
		shuffle($this->_deck);
        return $this;
    }

    /**
     * deal 4 hands of 7 cards 
     * @param bool $print
     * @param bool $shuffle
     * @return \deal
     */
    public function dealCards($print = FALSE) {
        try {
            $this->dealHand(7);
        } catch (Exception $exc) {
            throw new DealException;
        }
        if($print){
            $this->printCards();
        }
        return $this;
    }

    /**
     * deal number of cards for each hand, returns number of cards dealed
     * one card for each player on one round
     * @param int $cardNr
     */
    protected function dealHand($cardNr) {
		$this->generateDeck()->shuffleCards();
        for ($i = 1; $i <= $cardNr; $i++) {
            foreach ($this->_players as $player) {
                $this->_hands[$player][$i] = array_pop($this->_deck);
            }
        }
        return $this;
    }
                
    /**
     * print the cards on all hands
     * @param array $hands
     * @return \deal
     */
    public function printCards() {
        foreach ($this->_hands as $playerName => $hand) {
            print $playerName . ': ' . implode(' - ', $hand).PHP_EOL;
        }
        return $this;
    }
    
    /**
     * get card types ('Heart', 'Club', 'Diamond', 'Spade')
     * @return array
     */
    protected function getCardTypes() {
        return array('H', 'C', 'D', 'S');
    }
    
    /**
     * get cards of the types
     * ('Ace', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Jack', 'Queen', 'King')
     * @return array
     */
    protected function getCards() {
        return array('A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K');
    }
    
    /**
     * generate the cards deck from cardtypes and cards
     * set the $this->deck array count 52 cards
     * @return \cards
     */
    public function generateDeck() {
		// reset Deck
		$this->_deck = array();
        $cards = $this->getCards();
        foreach ($this->getCardTypes() as $type) {
            foreach ($cards as $card) {
                $this->_deck[] = $type.' '.$card;
            }
        }
        return $this;
    }
}
