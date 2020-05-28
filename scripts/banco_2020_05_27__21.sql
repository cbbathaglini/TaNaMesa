CREATE TABLE tb_atendente (
  idAtendente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NULL,
  PRIMARY KEY(idAtendente)
);

CREATE TABLE tb_categoria_prato (
  idCategoriaPrato INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  caractere CHAR(1) NOT NULL,
  PRIMARY KEY(idCategoriaPrato)
);

CREATE TABLE tb_funcionario (
  idFuncionario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(idFuncionario)
);

CREATE TABLE tb_ingrediente (
  idIngrediente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ingrediente VARCHAR(100) NOT NULL,
  index_ingrediente VARCHAR(100) NOT NULL,
  PRIMARY KEY(idIngrediente)
);

CREATE TABLE tb_mesa (
  idMesa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  situacao CHAR(1) NOT NULL,
  PRIMARY KEY(idMesa)
);

CREATE TABLE tb_perfil_usuario (
  idPerfilUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  index_perfil VARCHAR(200) NOT NULL,
  PRIMARY KEY(idPerfilUsuario)
);

CREATE TABLE tb_perfil_usuario_has_tb_recurso (
  idPerfilUsuarioRecurso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPerfilUsuario INTEGER UNSIGNED NOT NULL,
  idRecurso INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idPerfilUsuarioRecurso),
  INDEX tb_perfil_usuario_has_tb_recurso_FKIndex1(idPerfilUsuario),
  INDEX tb_perfil_usuario_has_tb_recurso_FKIndex2(idRecurso)
);

CREATE TABLE tb_prato (
  idPrato INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idCategoriaPrato INTEGER UNSIGNED NOT NULL,
  preco DOUBLE NOT NULL,
  nome VARCHAR(100) NOT NULL,
  informacoes VARCHAR(300) NOT NULL,
  index_nome VARCHAR(100) NOT NULL,
  PRIMARY KEY(idPrato),
  INDEX tb_prato_FKIndex1(idCategoriaPrato)
);

CREATE TABLE tb_prato_has_tb_ingrediente (
  idPratoIngrediente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tb_ingrediente_idIngrediente INTEGER UNSIGNED NOT NULL,
  idPrato INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idPratoIngrediente),
  INDEX tb_prato_has_tb_ingredientes_FKIndex1(idPrato)
);

CREATE TABLE tb_recurso (
  idRecurso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(300) NOT NULL,
  s_n_menu CHAR(1) NOT NULL,
  index_recurso VARCHAR(300) NOT NULL,
  PRIMARY KEY(idRecurso)
);

CREATE TABLE tb_usuario (
  idUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NULL,
  PRIMARY KEY(idUsuario)
);

CREATE TABLE tb_usuario_has_tb_perfil_usuario (
  idUsuarioPerfilUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPerfilUsuario INTEGER UNSIGNED NOT NULL,
  idUsuario INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idUsuarioPerfilUsuario),
  INDEX tb_usuario_has_tb_perfil_usuario_FKIndex1(idUsuario),
  INDEX tb_usuario_has_tb_perfil_usuario_FKIndex2(idPerfilUsuario)
);


