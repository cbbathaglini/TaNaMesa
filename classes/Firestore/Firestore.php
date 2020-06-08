<?php
require_once __DIR__.'/../../classes/Excecao/Excecao.php';
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

class Firestore{
    protected $db;
    protected $name;

    /**
     * Firestore constructor.
     */


    public function __construct(string $collection ){
        $this->db = new FirestoreClient([
           'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = $collection;
    }

    public function getDocument(string $name){
        try {
            if ($this->db->collection($this->name)->document($name)->snapshot()->exists()) {
                return $this->db->collection($this->name)->document($name)->snapshot()->data();
            } else {
                throw  new Excecao("Erro consultando o banco no firebase");
            }
        }catch (Throwable $e){
            die('aq');
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
        }catch (Throwable $e){
            die('aq');
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
        }catch (Throwable $e){
            die('aq');
        }
    }

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
    }*/

    public function list(){
        try {
            $arr = [];
            $query = $this->db->collection($this->name)->documents()->rows();
            if(!empty($query)){
                foreach ($query as $item){
                    $arr[]= $item->data();
                }
            }
            return $arr;
        }catch (Throwable $e){
            die('aq');
        }
    }

    public function newDocument(string $name, array $data = []){
        try {

            $this->db->collection($this->name)->document($name)->create($data);
            return true;
            $arr = [];

        }catch (Throwable $e){
            die('aq');
        }
    }

    public function newObject(string $name, $data){
        try {

            $this->db->collection($this->name)->document($name)->create((array)$data);
            return true;

        }catch (Throwable $e){
            die($e->getMessage());
        }
    }

    public function update(string $name, array $data = []){
        try {

            $this->db->collection($this->name)->document($name)->set($data);
            return true;
            $arr = [];

        }catch (Throwable $e){
            die($e->getMessage());
        }
    }

    public function newCollection(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $e){
            die('aq');
        }
    }

    public function dropDocument(string $documentName){
        try {

            $this->db->collection($this->name)->document($documentName)->delete();

        }catch (Throwable $e){
            die('aq');
        }
    }

    public function dropCollection(string $collectionName){
        try {

            $documents = $this->db->collection($collectionName)->limit(1)->documents();
            while (!$documents->isEmpty()){
                foreach ($documents as $item){
                    $item->reference()->delete();
                }
            }

        }catch (Throwable $e){
            die('aq');
        }
    }
}