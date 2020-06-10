<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class RecursoBDFirestore{
    protected $db;
    protected $name;


    public function __construct(){
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'recursos';
    }

    public function cadastrar(Recurso $objRecurso){
        try {

            $objRecurso->setIdRecurso(($this->ultimoId()+1));
            $arr = $this->retornar_array($objRecurso);
            if($this->ultimoId() == 0){
                //criar tabela
                $this->novaColecao($this->name,$objRecurso->getIdRecurso(),$arr);
            }else {
                $this->db->collection($this->name)->document($objRecurso->getIdRecurso())->create($arr);
            }
            return $objRecurso;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o recurso no BD.",$ex);
        }
    }


    public function alterar(Recurso $objRecurso){
        try {

            $arr = $this->retornar_array($objRecurso);
            $this->db->collection($this->name)->document($objRecurso->getIdRecurso())->set($arr);
            return $objRecurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o recurso no BD.", $ex);
        }
    }

    public function retornar_array($recursos_obj){
        try {

            if(is_array($recursos_obj)){
                foreach ($recursos_obj as $recurso){
                    $arr[] = array(   'idRecurso' => $recurso->getIdRecurso(),
                        'index_recurso' =>$recurso->getIndexRecurso(),
                        'recurso' =>$recurso->getNome(),
                        'SNMenu' =>$recurso->getSNMenu(),
                        'link_recurso' =>$recurso->getLink()
                    );
                }
            }else{
                $arr = array(   'idRecurso' => $recursos_obj->getIdRecurso(),
                    'index_recurso' =>$recursos_obj->getIndexRecurso(),
                    'recurso' =>$recursos_obj->getNome(),
                    'SNMenu' =>$recursos_obj->getSNMenu(),
                    'link_recurso' =>$recursos_obj->getLink()
                );
            }

            return $arr;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os atributos do recurso no BD.", $ex);
        }
    }

    public function listar(Recurso $objRecurso, $numLimite = null){
        try {
            $arr = [];
            $query = $this->db->collection($this->name);

            if($objRecurso->getIdRecurso() != null){
                $query = $query->where('idRecurso','=',$objRecurso->getIdRecurso());
            }

            if($objRecurso->getSNMenu() != null){
                $query = $query->where('SNMenu','=',$objRecurso->getSNMenu());
            }

            if($objRecurso->getNome() != null){
                $query = $query->where('recurso','=',$objRecurso->getNome());
            }

            if($objRecurso->getIndexRecurso() != null){
                $query = $query->where('index_recurso','=',$objRecurso->getIndexRecurso());
            }

            if($objRecurso->getLink() != null){
                $query = $query->where('link_recurso','=',$objRecurso->getLink());
            }

            if($numLimite != null){
                $query = $query->limit($numLimite);
            }
            $query = $query->orderBy('idRecurso');
            $query = $query->documents()->rows();
            if(!empty($query)){
                foreach ($query as $item){
                    $recurso = new Recurso();
                    $recurso->setIdRecurso($item->data()['idRecurso']);
                    $recurso->setIndexRecurso($item->data()['index_recurso']);
                    $recurso->setNome($item->data()['recurso']);
                    $recurso->setSNMenu($item->data()['SNMenu']);
                    $recurso->setLink($item->data()['link_recurso']);
                    $arr[]= $recurso;
                }
            }
            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro listando os recursos no BD.",$ex);
        }
    }

    public function consultar(Recurso $objRecurso){
        try {

            $query = $this->db->collection($this->name)->document($objRecurso->getIdRecurso())->snapshot()->data();

            if(!empty($query)){
                $recurso = new Recurso();
                $recurso->setIdRecurso($query['idRecurso']);
                $recurso->setIndexRecurso($query['index_recurso']);
                $recurso->setNome($query['recurso']);
                $recurso->setSNMenu($query['SNMenu']);
                $recurso->setLink($query['link_recurso']);
                return  $recurso;
            }

            return null;
        }catch (Throwable $ex) {
            throw new Excecao("Erro consultando o recurso no BD.",$ex);
        }
    }

    public function ultimoId(){
        try {
            $query = $this->db->collection($this->name)->documents()->rows();

            if(!empty($query)) {
                $maior  =  -1;
                foreach ($query as $item) {
                    if($maior < $item->data()['idRecurso']){
                        $maior  =  $item->data()['idRecurso'];
                        echo $maior;
                    }

                }
            }
            return $maior;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o recurso no BD.",$ex);
        }
    }

    public function remover(Recurso $objRecurso){
        try {
            $this->db->collection($this->name)->document($objRecurso->getIdRecurso())->delete();

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo o recurso no BD.",$ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o recurso no BD.",$ex);
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
            throw new Excecao("Erro removendo a tabela recurso no BD.",$ex);
        }
    }
}