<?php
    
    /*
     * Esse script, por meio de expressões regulares, captura e trata as informações
     * devolvendo ao usuario, informações referente aos Filmes que estão em cartaz no momento
     */
    
    include_once('simple_html_dom.php');
    include_once('xml.class.php');
  
    class Filmes{
        private $urlPrincipal = "http://www.rivershopping.com.br/cinema.aspx";
        
        private $element    = null;
        private $filmes     = null;
        private $censura    = null;
        private $horarios   = null;
        private $sinopse    = null;
        private $retorno    = null;
        private $capas      = null;
        
        public function __construct(){
            $this->emCartaz();
        }
        
        private function xml(){
            $xml = new Xml;
            $xml->openTag('conteudo');
            $controleSinopse = 0;
            $controleHorarios = 0;
            $controleCensura = 0;
            
            $this->sinopse = explode('<br>',$this->sinopse); //Transforma em um array
            $tamanho = sizeof($this->sinopse); //Pega o tamanho dos arrays 
            $tamanho = $tamanho - 1; //Remove o espaço em branco no final de todos os arrays
            $this->filmes = explode('<br>',$this->filmes); //Transforma em um array
            $this->horarios = explode('<br>',$this->horarios); //Trabsforma em um array
            $this -> censura = explode('<br>',$this -> censura); //Transforma em um array

            for($i = 0; $i < $tamanho; $i++){
                $xml ->addTag('filme', $this->filmes[$i]);
                    //Responsavel por exibir as sinopses
                    for($j = $controleSinopse; $j < $tamanho; $j++){
                        $xml ->addTag('sinopse', $this->sinopse[$j]);
                        $controleSinopse++;
                        break;
                    }
                    //Responsavel por exibir os horarios dos filmes
                    for($w = $controleHorarios; $w < $tamanho; $w++){
                        $xml ->addTag('horario', $this->horarios[$w]);
                        $controleHorarios++;
                        break;
                    }
                    //Responsavel por exibir as censuras dos filmes
                    for($q = $controleCensura; $q < $tamanho; $q++){
                        $xml -> addTag('censura',$this->censura[$q]);
                        $controleCensura++;
                        break;
                    }
            }
            $xml->closeTag('conteudo');
            echo $xml;
        }

        //Esse método captura as informações da $urlPrincipal
        private function emCartaz(){
           $html = file_get_html($this->urlPrincipal);
           
           //Esse foreach captura as informações antes de serem tratadas
           foreach($html->find('td.texto_padrao') as $element){
               $this -> element .= $element->plaintext.'<br>';
           }
           
           $this->retorno = explode('<br>',$this->element);
           $tamanho = sizeof($this->retorno);
           
           //Responsavel por pegar apenas a sinopse do filme
           for($i = 3; $i < $tamanho; $i+=15){
              $this->sinopse .= $this->retorno[$i].'<br>';
           }
           //Responsavel por pegar apenas a cencura do filme
           for($i = 8; $i < $tamanho; $i+=15){
               $this->censura .= $this->retorno[$i].'<br>';
           }
           //Responsavel por pegas apenas o hórario do filme
           for($i = 14; $i < $tamanho; $i+=15){
               $this->horarios .= $this->retorno[$i].'<br>';
           }
           
           $this->element = null; //Remove todas as informações que a variavel já tinha quardada
           
           //Esse foreach captura o titulo do filme
           foreach($html->find('td.cinema_titulo') as $element){
               $this->filmes .= $element->plaintext.'<br>';
           }
           
           //Esse foreach captura apenas as capas dos filmes
           foreach($html->find('td.Figura4 img') as $element){
               $this -> capas .= $element;
           }
           
           $this -> capas = explode('img src=',$this->capas);
           echo '<pre>';
           print_r($this->capas);

           //$this->xml(); //chama método responsavel por gerar o xml
        }
        
        private function isOnline(){
            $header = get_headers($this->urlPrincipal);
        }
    }
?>
