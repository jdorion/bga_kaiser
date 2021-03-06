<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * ThreeSpot implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * threespot.view.php
 *
 * This is your "view" file.
 *
 * The method "build_page" below is called each time the game interface is displayed to a player, ie:
 * _ when the game starts
 * _ when a player refreshes the game page (F5)
 *
 * "build_page" method allows you to dynamically modify the HTML generated for the game interface. In
 * particular, you can set here the values of variables elements defined in threespot_threespot.tpl (elements
 * like {MY_VARIABLE_ELEMENT}), and insert HTML block elements (also defined in your HTML template file)
 *
 * Note: if the HTML of your game interface is always the same, you don't have to place anything here.
 *
 */
  
  require_once( APP_BASE_PATH."view/common/game.view.php" );
  
  class view_threespot_threespot extends game_view
  {
    function getGameName() {
        return "threespot";
    }    
  	function build_page( $viewArgs )
  	{		
  	    // Get players & players number
        $players = $this->game->loadPlayersBasicInfos();
        $players_nbr = count( $players );

        /*********** Place your code below:  ************/
        $template = self::getGameName() . "_" . self::getGameName();
        
        // adjust this so that the current player is always S
        $directions = array( 'S', 'W', 'N', 'E' );

        // find out if the current player is player 1, 2, 3, or 4
        global $g_user;
        $current_player_id = $g_user->get_id();
        $current_player_index = 0;
        $current_index = 0;
        foreach ( $players as $player_id => $info ) {
            if ($player_id == $current_player_id) {
                $current_player_index = $current_index;
                break;
            } else {
                $current_index = $current_index + 1;
            }
        }

        // only shift the array if it is necessary
        if ($current_player_index > 0) {
            // shift it x times
            for ($x = 1; $x <= $current_player_index; $x++) {
                $popped = array_pop($directions);
                array_unshift($directions, $popped);
            }
        }

        // this will inflate our player block with actual players data
        $this->page->begin_block($template, "player");
        foreach ( $players as $player_id => $info ) {
            $dir = array_shift($directions);
            $this->page->insert_block("player", array ("PLAYER_ID" => $player_id,
                    "PLAYER_NAME" => $players [$player_id] ['player_name'],
                    "PLAYER_COLOR" => $players [$player_id] ['player_color'],
                    "DIR" => $dir ));
        }
        // this will make our My Hand text translatable
        $this->tpl['MY_HAND'] = self::_("My hand");
        $this->tpl['HAND_INFO'] = self::_("Hand info");

        /*
        
        // Examples: set the value of some element defined in your tpl file like this: {MY_VARIABLE_ELEMENT}

        // Display a specific number / string
        $this->tpl['MY_VARIABLE_ELEMENT'] = $number_to_display;

        // Display a string to be translated in all languages: 
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::_("A string to be translated");

        // Display some HTML content of your own:
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::raw( $some_html_code );
        
        */
        
        /*
        
        // Example: display a specific HTML block for each player in this game.
        // (note: the block is defined in your .tpl file like this:
        //      <!-- BEGIN myblock --> 
        //          ... my HTML code ...
        //      <!-- END myblock --> 
        

        $this->page->begin_block( "threespot_threespot", "myblock" );
        foreach( $players as $player )
        {
            $this->page->insert_block( "myblock", array( 
                                                    "PLAYER_NAME" => $player['player_name'],
                                                    "SOME_VARIABLE" => $some_value
                                                    ...
                                                     ) );
        }
        
        */



        /*********** Do not change anything below this line  ************/
  	}
  }
  

