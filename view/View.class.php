<?php

class View {

    static private function fullFormatDate($date) {

        $date = date_create($date);
        return date_format($date, "F d") . ", " . date_format($date, "Y");
    }

    static private function replaceTemplate($tile, $template) {

        $html = str_replace("%title%", $tile['title'], $template);
        $html = str_replace("%img%", $tile['img'], $html);
        $html = str_replace("%img_alt%", $tile['img_alt'], $html);
        $html = str_replace("%author_icon%", $tile['icon'], $html);
        $html = str_replace("%type%", $tile['type'], $html);
        $html = str_replace("%id_tiles%", $tile['id_tiles'], $html);

        if($tile['show_date'] === 'f') {
            $tile['date'] = '&nbsp;';
            $html = str_replace("%fullFormatDate%", $tile['date'], $html);
        } else {
            $html = str_replace("%fullFormatDate%", self::fullFormatDate($tile['date']), $html);
        }

        $html = str_replace("%date%", $tile['date'], $html);

        return $html;
    }

    static public function showTiles($tiles) {

        $templateMain = '
            <article class="main-tile">
                <img src="assets/img/%img%" class="main-tile__img" alt="%img_alt%">
                <div class="main-tile__container">
                    <time datetime="%date%" class="main-tile__date">%fullFormatDate%</time>
                    <h2 class="main-tile__heading">%title%</h2>
                </div>
            </article>
        ';

        $templateNorm = '
            <article class="tile">
                <img src="assets/img/%img%" class="tile__img" alt="%img_alt%">
                <time datetime="%date%" class="tile__date">%fullFormatDate%</time>
                <h2 class="tile__heading">%title%</h2>
                <img src="assets/img/%author_icon%" class="tile__author" alt="Author">
            </article>
        ';

        $result = "";
        
        foreach($tiles as $tile) {

            if($tile['type'] === 'main') {

                $result .= self::replaceTemplate($tile, $templateMain);

            } else {

                $result .= self::replaceTemplate($tile, $templateNorm);
            }
        }

        return $result;   
    }

    static public function getTilesTable($name, $tiles) {

        $template = '
            <tr id="'. $name .'_id-%id_tiles%" class="'. $name .'-tiles">
                <td>%id_tiles%</td>
                <td>%title%</td>
                <td>%type%</td>
                <td>%img%</td>
                <td>%img_alt%</td>
                <td>%date%</td>
            </tr>
        ';

        $result = "";

        foreach($tiles as $tile) {

            $result .= self::replaceTemplate($tile, $template);
        }

        return $result;

    }

    static public function renderTilesTemplate($tiles) {

        require_once('templates/index.php');
        
        echo str_replace("%tiles%", $tiles, $template);
    }

    static public function renderFormTemplate($data) {

        require_once('templates/form.php');

        $html =  str_replace("%errors%", $data['error'], $template);
        $html =  str_replace("%success%", $data['success'], $html);
        $html =  str_replace("%tableEdit%", $data['table_edit'], $html);
        $html =  str_replace("%tableRemove%", $data['table_remove'], $html);

        echo $html;
    }

    static public function renderEditTemplate($id) {

        require_once('templates/edit.php');

        echo str_replace("%id%", $id, $template);
    }
}