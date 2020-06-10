<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class PerfilUsuarioBDFirestore{
    protected $db;
    protected $name;


    public function __construct(){
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'perfilUsuario';
    }

    public function cadastrar(PerfilUsuario $objPerfilUsuario){
        try {


            $objPerfilUsuario->setIdPerfilUsuario(($this->quantidadeObjetos()+1));
            $arr = $this->retornar_array($objPerfilUsuario);

            if($this->quantidadeObjetos() == 0){
                //criar tabela
                $this->novaColecao($this->name,$objPerfilUsuario->getIdPerfilUsuario(),$arr);
            }else {
                $this->db->collection($this->name)->document($objPerfilUsuario->getIdPerfilUsuario())->create($arr);
            }
            return $objPerfilUsuario;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o perfil do usuário no BD.",$ex);
        }
    }


    public function alterar(PerfilUsuario $objPerfilUsuario){
        try {

            $arr = $this->retornar_array($objPerfilUsuario);
            $this->db->collection($this->name)->document($objPerfilUsuario->getIdPerfilUsuario())->set($arr);
            return $objPerfilUsuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o perfil do usuário no BD.", $ex);
        }
    }

    public function listar(PerfilUsuario $objPerfilUsuario, $numLimite = null){
        try {

            $arr = [];
            $query = $this->db->collection($this->name);

            if($objPerfilUsuario->getIdPerfilUsuario() != null){
                $query = $query->where('idPerfilUsuario','=',$objPerfilUsuario->getIdPerfilUsuario());
            }

            if($objPerfilUsuario->getIndex_perfil() != null){
                $query = $query->where('index_perfil','=',$objPerfilUsuario->getIndex_perfil());
            }

            if($objPerfilUsuario->getPerfil() != null){
                $query = $query->where('perfil','=',$objPerfilUsuario->getPerfil());
            }

            if($numLimite != null){
                $query = $query->limit($numLimite);
            }
            $query = $query->documents()->rows();

            if(!empty($query)){
                foreach ($query as $item){
                    $perfilUsuario = new PerfilUsuario();
                    $perfilUsuario->setIdPerfilUsuario($item->data()['idPerfilUsuario']);
                    $perfilUsuario->setIndex_perfil($item->data()['index_perfil']);
                    $perfilUsuario->setPerfil($item->data()['perfil']);
                    $arr[]= $perfilUsuario;
                }
            }

            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro listando os perfis de usuário no BD.",$ex);
        }
    }

    public function retornar_array($perfisUsuario_obj){
        try {

            if(is_array($perfisUsuario_obj)){
                foreach ($perfisUsuario_obj as $perfilUsuario){
                    $arr[] = array(   'idPerfilUsuario' => $perfilUsuario->getIdPerfilUsuario(),
                        'index_perfil' =>$perfilUsuario->getIndex_perfil(),
                        'perfil' =>$perfilUsuario->getPerfil()
                    );
                }
            }else{
                $arr = array(   'idPerfilUsuario' => $perfisUsuario_obj->getIdPerfilUsuario(),
                    'index_perfil' =>$perfisUsuario_obj->getIndex_perfil(),
                    'perfil' =>$perfisUsuario_obj->getPerfil()
                );
            }

            return $arr;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os atributos do perfil usuário no BD.", $ex);
        }
    }

    public function consultar(PerfilUsuario $objPerfilUsuario){
        try {

            $query = $this->db->collection($this->name)->document($objPerfilUsuario->getIdPerfilUsuario())->snapshot()->data();
            if(!empty($query)){
                $perfilUsuario = new PerfilUsuario();
                $perfilUsuario->setIdPerfilUsuario($query['idPerfilUsuario']);
                $perfilUsuario->setIndex_perfil($query['index_perfil']);
                $perfilUsuario->setPerfil($query['perfil']);
                return  $perfilUsuario;
            }

            return null;
        }catch (Throwable $ex) {
            throw new Excecao("Erro consultando o perfil do usuário no BD.",$ex);
        }
    }

    public function quantidadeObjetos(){
        try {
            $query = $this->db->collection($this->name)->documents()->rows();
            return count($query);
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o perfil do usuário no BD.",$ex);
        }
    }

    public function remover(PerfilUsuario $objPerfilUsuario){
        try {
            $this->db->collection($this->name)->document($objPerfilUsuario->setIdPerfilUsuario())->delete();

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo o perfil do usuário no BD.",$ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o perfil do usuário no BD.",$ex);
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
            throw new Excecao("Erro removendo a tabela perfil do usuário no BD.",$ex);
        }
    }

}
