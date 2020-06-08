<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class PratoBD{
    protected $db;
    protected $name;


    public function __construct(){
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'pratos';
    }

    public function cadastrar(Prato $objPrato){
        try {

            $objPrato->setIdPrato(($this->ultimoId()+1));
            $arr = $this->retornar_array($objPrato);
            if($this->ultimoId() == 0){
                //criar tabela
                $this->novaColecao($this->name,$objPrato->getIdPrato(),$arr);
            }else {
                $this->db->collection($this->name)->document($objPrato->getIdPrato())->create($arr);
            }
            return $objPrato;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o prato no BD.",$ex);
        }
    }


    public function alterar(Prato $objPrato){
        try {

            $arr = $this->retornar_array($objPrato);
            $this->db->collection($this->name)->document($objPrato->getIdPrato())->set($arr);
            return $objPrato;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o prato no BD.", $ex);
        }
    }

    public function retornar_array($pratos_obj){
        try {

            if(is_array($pratos_obj)){
                foreach ($pratos_obj as $prato){
                    $arr[] = array(   'idPrato' => $prato->getIdPrato(),
                        'categoriaPrato' =>$prato->getCategoriaPrato(),
                        'lista_ingredientes' =>$prato->getListaIngredientes(),
                        'prato' =>$prato->getNome(),
                        'index_prato' =>$prato->getIndex_nome(),
                        'preco' =>$prato->getPreco(),
                        'informacoes' =>$prato->getInformacoes()
                    );
                }
            }else{
                $arr = array(   'idPrato' => $pratos_obj->getIdPrato(),
                    'categoriaPrato' =>$pratos_obj->getCategoriaPrato(),
                    'lista_ingredientes' =>$pratos_obj->getListaIngredientes(),
                    'prato' =>$pratos_obj->getNome(),
                    'index_prato' =>$pratos_obj->getIndex_nome(),
                    'preco' =>$pratos_obj->getPreco(),
                    'informacoes' =>$pratos_obj->getInformacoes()
                );
            }

            return $arr;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os atributos do recurso no BD.", $ex);
        }
    }

    public function listar(Prato $objPrato, $numLimite = null){
        try {
            $arr = [];
            $query = $this->db->collection($this->name);

            if($objPrato->getIdPrato() != null){
                $query = $query->where('idPrato','=',$objPrato->getIdPrato());
            }

            if($objPrato->getPreco() != null){
                $query = $query->where('preco','=',$objPrato->getPreco());
            }

            if($objPrato->getNome() != null){
                $query = $query->where('index_prato','=',$objPrato->getNome());
            }

            if($numLimite != null){
                $query = $query->limit($numLimite);
            }
            $query = $query->orderBy('idRecurso');
            $query = $query->documents()->rows();
            if(!empty($query)){
                foreach ($query as $item){
                    $prato = new Prato();
                    $prato->setIdPrato($item->data()['idPrato']);
                    $prato->setNome($item->data()['prato']);
                    $prato->setIndexNome($item->data()['index_prato']);
                    $prato->setCategoriaPrato($item->data()['categoriaPrato']);
                    $prato->setPreco($item->data()['preco']);
                    $prato->setInformacoes($item->data()['informacoes']);
                    $prato->setListaIngredientes($item->data()['lista_ingredientes']);
                    $arr[]= $prato;
                }
            }
            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro listando os recursos no BD.",$ex);
        }
    }

    public function consultar(Prato $objPrato){
        try {

            $query = $this->db->collection($this->name)->document($objPrato->getIdPrato())->snapshot()->data();

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
            throw new Excecao("Erro consultando o prato no BD.",$ex);
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
            throw new Excecao("Erro cadastrando o prato no BD.",$ex);
        }
    }

    public function remover(Prato $objPrato){
        try {
            $this->db->collection($this->name)->document($objPrato->getIdPrato())->delete();

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo o prato no BD.",$ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o prato no BD.",$ex);
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