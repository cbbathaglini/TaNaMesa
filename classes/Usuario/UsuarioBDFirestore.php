<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;
class UsuarioBDFirestore
{
    protected $db;
    protected $name;


    public function __construct()
    {
        $this->db = new FirestoreClient([
            'projectId' => 'ta-na-mesa-mobile'
        ]);
        $this->name = 'usuarios';
    }

    public function cadastrar(Usuario $objUsuario)
    {
        try {

            $objUsuario->setIdUsuario(($this->quantidadeObjetos() + 1));
            $arr = array('idUsuario' => $objUsuario->getIdUsuario(),
                'nome' => $objUsuario->getNome(),
                'senha' => $objUsuario->getSenha(),
                'CPF' => $objUsuario->getCPF(),
                'lista_perfis' =>  $objUsuario->getListaPerfis(),
                'lista_recursos' => $objUsuario->getListaRecursos()
            );

            if ($this->quantidadeObjetos() == 0) {
                //criar tabela
                $this->novaColecao($this->name, $objUsuario->getIdUsuario(), $arr);
            } else {
                $this->db->collection($this->name)->document($objUsuario->getIdUsuario())->create($arr);
            }
            return $objUsuario;

        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o usuário no BD.", $ex);
        }
    }

    public function alterar(Usuario $objUsuario)
    {
        try {
            $arr = array();

            if(count($objUsuario->getListaRecursos()) > 0) {
                $idsRecursos = '';
                foreach (array_unique($objUsuario->getListaRecursos()) as $recurso){
                    $idsRecursos .= $recurso.",";
                }
            }

            if(count($objUsuario->getListaPerfis()) > 0) {
                $idsPerfis = '';
                foreach (array_unique($objUsuario->getListaPerfis()) as $perfil){
                    $idsPerfis .= $perfil.",";
                }
            }

            $idsPerfis = substr($idsPerfis,0,-1);
            $idsRecursos = substr($idsRecursos,0,-1);


            $arr = array('idUsuario' => $objUsuario->getIdUsuario(),
                'nome' => $objUsuario->getNome(),
                'senha' => $objUsuario->getSenha(),
                'CPF' => $objUsuario->getCPF(),
                'lista_perfis' =>  $idsPerfis,
                'lista_recursos' => $idsRecursos
            );

            $this->db->collection($this->name)->document($objUsuario->getIdUsuario())->set($arr);
            return $objUsuario;
        }  catch (Throwable $ex) {
            throw new Excecao("Erro alterando o usuário no BD.", $ex);
        }
    }

    public function listar(Usuario $objUsuario, $numLimite = null)
    {
        try {
            $arr = [];
            $query = $this->db->collection($this->name);

            if ($objUsuario->getIdUsuario() != null) {
                $query = $query->where('idUsuario', '=', $objUsuario->getIdUsuario());
            }

            if ($objUsuario->getNome() != null) {
                $query = $query->where('nome', '=', $objUsuario->getNome());
            }

            if ($objUsuario->getCPF() != null) {
                $query = $query->where('CPF', '=', $objUsuario->getCPF());
            }

            if ($objUsuario->getSenha() != null) {
                $query = $query->where('senha', '=', $objUsuario->getSenha());
            }

            if ($numLimite != null) {
                $query = $query->limit($numLimite);
            }
            $query = $query->documents()->rows();
            if (!empty($query)) {
                foreach ($query as $item) {
                    $usuario = new Usuario();
                    $usuario->setIdUsuario($item->data()['idUsuario']);
                    $usuario->setSenha($item->data()['senha']);
                    $usuario->setCPF($item->data()['CPF']);
                    $usuario->setNome($item->data()['nome']);
                    $usuario->setListaPerfis($item->data()['lista_perfis']);
                    $usuario->setListaRecursos($item->data()['lista_recursos']);

                    $arr[] = $usuario;
                }
            }
            return $arr;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os usuários no BD.", $ex);
        }
    }

    public function consultar(Usuario $objUsuario)
    {
        try {

            $query = $this->db->collection($this->name)->document($objUsuario->getIdUsuario())->snapshot()->data();

            if (!empty($query)) {
                $usuario = new Usuario();
                $usuario->setIdUsuario($query['idUsuario']);
                $usuario->setSenha($query['senha']);
                $usuario->setCPF($query['CPF']);
                $usuario->setNome($query['nome']);
                $usuario->setListaPerfis($query['lista_perfis']);
                $usuario->setListaRecursos($query['lista_recursos']);
                return $usuario;
            }

            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o usuário no BD.", $ex);
        }
    }

    public function quantidadeObjetos()
    {
        try {
            $query = $this->db->collection($this->name)->documents()->rows();
            return count($query);
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o usuário no BD.", $ex);
        }
    }

    public function remover(Usuario $objUsuario)
    {
        try {
            $this->db->collection($this->name)->document($objUsuario->getIdUsuario())->delete();

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o usuário no BD.", $ex);
        }
    }

    public function novaColecao(string $nameCollection, string $documentName, array $data = [])
    {
        try {

            $this->db->collection($nameCollection)->document($documentName)->create($data);
            return true;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o usuário no BD.", $ex);
        }
    }


    public function removerTabela()
    {
        try {

            $documents = $this->db->collection($this->name)->limit(1)->documents();
            while (!$documents->isEmpty()) {
                foreach ($documents as $item) {
                    $item->reference()->delete();
                }
            }

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a tabela usuário no BD.", $ex);
        }
    }
}
