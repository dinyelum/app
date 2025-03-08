<?php
class Bookmakers extends Controller {
    function index() {
        $this->page = $this->activepage = 'bookies';
        $this->tags = true;
        $this->urls = bookies_link('', true);
        $this->style = ".w3-table th, .w3-table td {text-align: center;} .w3-table a {text-decoration: none; color:blue;} .w3-table a:hover {text-decoration: underline;}";
        $bookiesclass = new Bookies;
        if(isset($_GET['bookie'])) {
            $validbookie = $bookiesclass->validate($_GET);
            if(!isset($validbookie[1]['bookie'])) {
                $singlebookie = $bookiesclass->select('bookie, reflink')->where("bookie=:bookie and active=1", ['bookie'=>$validbookie[0]['bookie']]);
            }
        }
        $bookiedata = $bookiesclass->select('bookie, reflink, promocode, countries')->where("active=1 and (countries='all' || countries like '%".USER_COUNTRY."%')");
        if(is_array($bookiedata)) {
            foreach($bookiedata as $ind=>$val) {
                $formatted_bookiedata[$val['bookie']] = $val;
            }
        }
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Bookmakers";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers bookmakers';
            $this->description = 'The bookies we work with at betagamers.';
            $tableheader = ['Bookie', 'Action', 'Promo Code'];
            $prompt = 'Create a ... Account';
            $redirect = 'Taking You to ... in';
            $precount = 'Loading';
            $alt = 'OR #click here# to go immediately';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Bookmakers";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web betagamers, www.betagamers.net, conseils sportifs, site de pronostics sportifs précis, bookmakers betagamers';
            $this->description = 'Les bookmakers que nous utilisons chez betagamers.';
            $tableheader = ['Bookie', 'Action', 'Le code promo'];
            $prompt = 'Créer un compte ...';
            $redirect = 'Nous vous emmenons à ... en';
            $precount = 'Chargement';
            $alt = 'OR #cliquez ici# pour vous y rendre immédiatement';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Los corredores de apuestas";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio de betagamers, es.betagamers.net, las ofertas de casas de apuestas';
            $this->description = 'Las ofertas de casas de apuestas.';
            $tableheader = ['Corredor de apuestas', 'Acción', 'Código promocional'];
            $prompt = 'Crear una cuenta en ...';
            $redirect = 'Llevándote a ... en';
            $precount = 'Cargando';
            $alt = 'O #Haz clic aquí# para ir inmediatamente';
        } 
        $data['prompt'] = $prompt;
        $data['redirect'] = str_replace('...', $singlebookie[0]['bookie'] ?? '...', $redirect);
        $data['precount'] = "$precount...";
        $data['alt'] = tag_format($alt, [['href'=>$singlebookie[0]['reflink'] ?? '', 'style'=>'color:green; text-decoration:underline']]);
        $data['tableheader'] = $tableheader;
        $data['singlebookie'] = $singlebookie ?? [];
        $data['bookiedata'] = $formatted_bookiedata ?? [];
        $this->view("bookies",$data);
    }
}