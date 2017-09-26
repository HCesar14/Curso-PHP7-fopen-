<?php

class Usuario{

	private $id;
	private $deslogin;
	private $dessenha;

	public function getId(){
		return $this->id;
	}

	public function setId($value){
		$this->id = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function loadById($id){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM usuarios WHERE id = :ID", array(
			":ID"=>$id
		));

		if(count($results) > 0){

			$this->setData($results[0]);
		}
	}

	public static function getList(){

		$sql = new Sql();

		return $sql->select("SELECT * from usuarios order by deslogin");
	}

	public static function search($login){

		$sql = new Sql();

		return $sql->select("SELECT * from usuarios where deslogin like :SEARCH order by deslogin", array(
			":SEARCH"=>"%".$login."%"
		));		
	}

	public function login($login, $senha){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM usuarios WHERE deslogin = :LOGIN and dessenha = :SENHA", array(
			":LOGIN"=>$login,
			":SENHA"=>$senha
		));

		if(count($results) > 0){

			$this->setData($results[0]);
		}else{

			throw new Exception("Login e/ou senha invalidos");
			
		}
	}

	public function setData($data){

		$this->setId($data['id']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
	}

	public function insert(){

		$sql = new Sql();

		$results = $sql->select("CALL inserir_usuario(:LOGIN, :SENHA)",array(
			":LOGIN"=>$this->getDeslogin(),
			":SENHA"=>$this->getDessenha()
		));

		if(count($results) > 0){

			$this->setData($results[0]);
		}
	}

	public function update($login, $password){

		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE usuarios set deslogin = :LOGIN, dessenha = :SENHA where id = :ID", array(
			":LOGIN"=>$this->getDeslogin(),
			":SENHA"=>$this->getDessenha(),
			":ID"=>$this->getId()
		));
	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE from usuarios where id = :ID",array(
			':ID'=>$this->getId()
		));

		$this->setId("");
		$this->setDeslogin("");
		$this->setDessenha("");
	}

	public function __construct($login = "", $senha = ""){
		$this->setDeslogin($login);
		$this->setDessenha($senha);
	}

	public function __toString(){

		return json_encode(array(
			"id"=>$this->getId(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha()
		));
	}
}

?>