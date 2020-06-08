<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class IngredienteBD
{
    protected $db;
    protected $name;


    public function __construct(){
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'ingredientes';
    }

    public function cadastrar(Ingrediente $objIngrediente){
        try {

            $objIngrediente->setIdIngrediente(($this->quantidadeObjetos()+1));
            $arr = array(   'idIngrediente' => $objIngrediente->getIdIngrediente(),
                            'index_ingrediente' =>$objIngrediente->getIndexIngrediente(),
                            'ingrediente' =>$objIngrediente->getIngrediente()
                );
            if($this->quantidadeObjetos() == 0){
                //criar tabela
                $this->novaColecao('ingredientes',$objIngrediente->getIdIngrediente(),$arr);
            }else {
                $this->db->collection($this->name)->document($objIngrediente->getIdIngrediente())->create($arr);
            }
            return $objIngrediente;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }


    public function alterar(Ingrediente $objIngrediente){
        try {

            $arr = array(   'idIngrediente' => $objIngrediente->getIdIngrediente(),
                'index_ingrediente' =>$objIngrediente->getIndexIngrediente(),
                'ingrediente' =>$objIngrediente->getIngrediente()
            );
            $this->db->collection($this->name)->document($objIngrediente->getIdIngrediente())->set($arr);
            return $objIngrediente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o ingrediente no BD.", $ex);
        }
    }

    public function listar(Ingrediente $objIngrediente, $numLimite = null){
        try {
            $arr = [];
            $query = $this->db->collection($this->name);

            if($objIngrediente->getIdIngrediente() != null){
                $query = $query->where('idIngrediente','=',$objIngrediente->getIdIngrediente());
            }

            if($objIngrediente->getIdIngrediente() != null){
                $query = $query->where('index_ingrediente','=',$objIngrediente->getIndexIngrediente());
            }

            if($objIngrediente->getIdIngrediente() != null){
                $query = $query->where('ingrediente','=',$objIngrediente->getIngrediente());
            }

            if($numLimite != null){
                $query = $query->limit($numLimite);
            }
            $query = $query->documents()->rows();
            if(!empty($query)){
                foreach ($query as $item){
                    $ingrediente = new Ingrediente();
                    $ingrediente->setIdIngrediente($item->data()['idIngrediente']);
                    $ingrediente->setIndexIngrediente($item->data()['index_ingrediente']);
                    $ingrediente->setIngrediente($item->data()['ingrediente']);
                    $arr[]= $ingrediente;
                }
            }
            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro listando os ingredientes no BD.",$ex);
        }
    }

    public function consultar(Ingrediente $objIngrediente){
        try {

            $query = $this->db->collection($this->name)->document($objIngrediente->getIdIngrediente())->snapshot()->data();

            if(!empty($query)){
                $ingrediente = new Ingrediente();
                $ingrediente->setIdIngrediente($query['idIngrediente']);
                $ingrediente->setIndexIngrediente($query['index_ingrediente']);
                $ingrediente->setIngrediente($query['ingrediente']);
                return  $ingrediente;
            }

            return null;
        }catch (Throwable $ex) {
            throw new Excecao("Erro consultando o ingrediente no BD.",$ex);
        }
    }

    public function quantidadeObjetos(){
        try {
            $query = $this->db->collection($this->name)->documents()->rows();
            return count($query);
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }

    public function remover(Ingrediente $objIngredientes){
        try {
            $this->db->collection($this->name)->document($objIngredientes->getIdIngrediente())->delete();

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo o ingrediente no BD.",$ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }


    public function removerTabela(){
        try {

            $documents = $this->db->collection($this->name)->limit(1)->documents();
            while (!$documents->isEmpty()){
                foreach ($documents as $item){
                    $item->reference()->delete();
                }
            }

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo a tabela ingrediente no BD.",$ex);
        }
    }

    /*public function getDocument(string $name){
        try {
            if ($this->db->collection($this->name)->document($name)->snapshot()->exists()) {
                return $this->db->collection($this->name)->document($name)->snapshot()->data();
            } else {
                throw  new Excecao("Erro consultando o banco no firebase");
            }
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }

    public function getWhere(string $field, string $operator, $value){
        try {
            $arr = [];
            $query = $this->db->collection($this->name)->where($field,$operator,$value)->documents()->rows();
            if(!empty($query)){
                foreach ($query as $item){
                    $arr[]= $item->data();
                }
            }
            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }

    public function getmulWhere($arr_datas){
        try {
            $arr = [];

            $query = $this->db->collection($this->name);
            //foreach ($arr_datas as $data){
            $query = $query->where('cpf','=', $arr_datas['cpf']);
            $query = $query->where('senha','=', $arr_datas['senha']);
            $query = $query->documents()->rows();

            if(!empty($query)){
                foreach ($query as $item){
                    $arr[]= $item->data();
                }
            }

            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    }*/

    /*public function clausulaOR($arr_datas){
        try {
            $arr = [];

            $query1 = $this->db->collection($this->name)->where('cpf','=', $arr_datas['cpf']);
            $query2 = $this->db->collection($this->name)->where('senha','=', $arr_datas['senha']);

            if(!empty($query1) || !empty($query2)){
                foreach ($query1 as $item){
                    $arr[]= $item->data();
                }
            }

            return $arr;
        }catch (Throwable $e){
            die('aq');
        }
    }


    public function novoObjeto(string $name, $data){
        try {

            $this->db->collection($this->name)->document($name)->create((array)$data);
            return true;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o ingrediente no BD.",$ex);
        }
    } */

}