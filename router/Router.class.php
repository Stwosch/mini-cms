<?php 

class Router {

    static function route() {
        
        if(!isset($_GET['page'])) {

            Controller::loadMainPage();

        } else {
            
            switch($_GET['page']) {

                case 'form': 
                    Controller::loadForm(); 
                break;

                case 'add-tile':
                    Controller::addTile();
                break;

                case 'edit':
                    Controller::editFormTile();
                break;

                case 'edit-tile':
                    Controller::editTile();
                break;

                case 'remove':
                    Controller::removeTile();
                break;

                case 'get-tiles':
                    Controller::getTiles();
                break;

                default: echo 'Error 404';
            }
        }
   
    }
}