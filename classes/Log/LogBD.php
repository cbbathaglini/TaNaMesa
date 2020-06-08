<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class LogBD{
    protected $db;
    protected $name;


    public function __construct(){
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'log';
    }

    public function cadastrar(Log $objLog){
        try {


            $objLog->setIdLog(($this->quantidadeObjetos()+1));
            $arr = $this->retornar_array($objLog);

            if($this->quantidadeObjetos() == 0){
                //criar tabela
                $this->novaColecao($this->name,$objLog->getIdLog(),$arr);
            }else {
                $this->db->collection($this->name)->document($objLog->getIdLog())->create($arr);
            }
            return $objLog;

        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o o log de erros no BD.",$ex);
        }
    }


    public function alterar(Log $objLog){
        try {

            $arr = $this->retornar_array($objLog);
            $this->db->collection($this->name)->document($objLog->getIdLog())->set($arr);
            return $objLog;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o o log de erros no BD.", $ex);
        }
    }

    public function listar(Log $objLog, $numLimite = null){
        try {

            $arr = [];
            $query = $this->db->collection($this->name);

            if($objLog->getIdLog() != null){
                $query = $query->where('idLog','=',$objLog->getIdLog());
            }

            if($objLog->getIdUsuario() != null){
                $query = $query->where('idUsuario','=',$objLog->getIdUsuario());
            }

            if($numLimite != null){
                $query = $query->limit($numLimite);
            }
            $query = $query->documents()->rows();

            if(!empty($query)){
                foreach ($query as $item){
                    $log = new Log();
                    $log->setIdLog($item->data()['idLog']);
                    $log->setDataHora($item->data()['dataHora']);
                    $log->setIdUsuario($item->data()['idUsuario']);
                    $log->setTexto($item->data()['texto']);
                }
            }

            return $arr;
        }catch (Throwable $ex) {
            throw new Excecao("Erro listando os perfis de usuário no BD.",$ex);
        }
    }

    public function retornar_array($log_obj){
        try {

            if(is_array($log_obj)){
                foreach ($log_obj as $log){
                    $arr[] = array(   'idLog' => $log->getIdLog(),
                        'dataHora' =>$log->getDataHora(),
                        'idUsuario' =>$log->getIdUsuario(),
                        'texto' =>$log->getTexto()
                    );
                }
            }else{
                $arr =  array(   'idLog' => $log_obj->getIdLog(),
                    'dataHora' =>$log_obj->getDataHora(),
                    'idUsuario' =>$log_obj->getIdUsuario(),
                    'texto' =>$log_obj->getTexto()
                );
            }

            return $arr;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os atributos do log no BD.", $ex);
        }
    }

    public function consultar(Log $objLog){
        try {

            $query = $this->db->collection($this->name)->document($objLog->setIdLog())->snapshot()->data();

            if(!empty($query)){
                $log = new Log();
                $log->setIdLog($query['idLog']);
                $log->setDataHora($query['dataHora']);
                $log->setIdUsuario($query['idUsuario']);
                $log->setTexto($query['texto']);
                return  $log;
            }

            return null;
        }catch (Throwable $ex) {
            throw new Excecao("Erro consultando o o log de erros no BD.",$ex);
        }
    }

    public function quantidadeObjetos(){
        try {
            $query = $this->db->collection($this->name)->documents()->rows();
            return count($query);
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o o log de erros no BD.",$ex);
        }
    }

    public function remover(Log $objLog){
        try {
            $this->db->collection($this->name)->document($objLog->setIdLog())->delete();

        }catch (Throwable $ex) {
            throw new Excecao("Erro removendo o o log de erros no BD.",$ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName,array $data = []){
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        }catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o o log de erros no BD.",$ex);
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
            throw new Excecao("Erro removendo a tabela o log de erros no BD.",$ex);
        }
    }

}
