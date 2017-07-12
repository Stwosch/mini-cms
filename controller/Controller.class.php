<?php

class Controller {

    static public function loadMainPage() {

        $tiles = Model::getPartTiles(0, 5);
        $html = View::showTiles($tiles);
        View::renderTilesTemplate($html);
    }

    static public function getTiles() {

        $rows = Model::testInput($_POST['rows']);
        $offset = Model::testInput($_POST['offset']);

        $result = Model::getPartTiles($offset, $rows);

        if($result !== false) {

            $html = View::showTiles($result);
            echo $html;

        } else {
            echo false; 
        }
    }

    static public function loadForm() {

        $tiles = Model::getTiles();
        $data['table_edit'] = View::getTilesTable('edit', $tiles);
        $data['table_remove'] = View::getTilesTable('remove', $tiles);


        $queries = Model::getQueryString();
        $data['error'] = Model::getError($queries);
        $data['success'] = Model::getSuccess($queries);

        View::renderFormTemplate($data);
        
    }

    static public function addTile() {

        if(!isset($_POST['add-tile'])) {

            header("Location: form");
            return false;
        }

        
        $validForm = Model::validationForm();

        if(is_array($validForm)) {


            $validImg = Model::validationImg();

            if(is_numeric($validImg) === false && $validImg !== false) {

                $validForm['img'] = $validImg;

                $result = Model::saveTileToDB($validForm);
                Model::redirectAddTile($result);

            } else {

                Model::redirectAddTile($validImg);
            }


        } else {

            Model::redirectAddTile($validForm);
        }
    }

    static public function editFormTile() {

        $queries = Model::getQueryString();
        $id = Model::checkIdExists($queries);

        if($id === false) {
            echo "Error 404";
            return false;
        }  

        View::renderEditTemplate($id);
    }

    static public function editTile() {

        if(!isset($_POST['edit-tile'])) {

            header("Location: form");
            return false;
        }

        $tile = Model::validationForm();

        if(!is_array($tile)) {

            header("Location: form?error=" . $tile);
            return false;
        };

        $tile['id'] = Model::validationId($_POST['id']);
        $tile['id'] = Model::checkIdExists($tile);

        if($tile['id'] === false) {
            
            header("Location: form?error=7");
            return false;
        }
        
        $validImg = Model::validationImg($_FILES['img']);

        if(is_numeric($validImg) === false && $validImg !== false) {

            $tile['img'] = $validImg;

        } else if($validImg !== 4) {

            header('Location: form?error=' . $validImg);
            return false;
        }

        $result = Model::editTile($tile);
        
        if($result !== false) {

            if(isset($tile['img'])) {

                $removeResult = Model::removeImg($result);

                if(!$removeResult) {

                    header('Location: form?error=9');

                } else {

                    header("Location: form?success=2");
                }


            } else {

                 header("Location: form?success=2");
            }


        } else {

            header("Location: form?error=8");
        }
    }

    static public function removeTile() {

        $queries = Model::getQueryString();
        $id = Model::checkIdExists($queries);

        if($id === false) {
            echo "Error 404";
            return false;
        }  

        $result = Model::removeTileFromDB($id);

        if($result) {

            header("Location: form?success=3");
        } else {
            header("Location: form?error=10");
        }

    }
}