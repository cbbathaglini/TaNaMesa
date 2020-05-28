alter table tb_mesa add numero integer(4) not null;
alter table tb_mesa add numLugares integer(3) null;


  insert into tb_recurso (nome,s_n_menu,index_recurso) values ('cadastrar_usuario_perfilUsuario','s','CADASTRAR_USUARIO_PERFILUSUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_usuario_perfilUsuario'));



       insert into tb_recurso (nome,s_n_menu,index_recurso) values ('listar_usuario_perfilUsuario','s','LISTAR_USUARIO_PERFILUSUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso)VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_usuario_perfilUsuario'));


      insert into tb_recurso (nome,s_n_menu,index_recurso) values ('cadastrar_perfilUsuario_recurso','s','CADASTRO_PERFILUSUARIO_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_perfilUsuario_recurso'));

           insert into tb_recurso (nome,s_n_menu,index_recurso) values ('listar_perfilUsuario_recurso','s','LISTAR_PERFILUSUARIO_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_perfilUsuario_recurso'));


       insert into tb_recurso (nome,s_n_menu,index_recurso) values ('cadastrar_recurso','s','CADASTRAR_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_recurso'));

         insert into tb_recurso (nome,s_n_menu,index_recurso) values ('editar_recurso','s','EDITAR_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_recurso'));

      insert into tb_recurso (nome,s_n_menu,index_recurso) values ('remover_recurso','s','REMOVER_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_recurso'));

     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('listar_recurso','s','LISTAR_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_recurso'));



     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('editar_perfilUsuario_recurso','s','EDITAR_PREFILUSUARIO_RECURSO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_perfilUsuario_recurso'));



      ---
      insert into tb_recurso (nome,s_n_menu,index_recurso) values ('cadastrar_perfil_usuario','s','CADASTRAR_PERFIL_USUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_perfil_usuario'));
     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('editar_perfil_usuario','s','EDITAR_PERFIL_USUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_perfil_usuario'));
     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('listar_perfil_usuario','s','LISTAR_PERFIL_USUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_perfil_usuario'));
     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('remover_perfil_usuario','s','REMOVER_PERFIL_USUARIO');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_perfil_usuario'));


     insert into tb_recurso (nome,s_n_menu,index_recurso) values ('gerar_QRCodes','s','GERAR_QRCODES');

insert into tb_perfil_usuario_has_tb_recurso (idPerfilUsuario,idRecurso) VALUES
   ((SELECT idPerfilUsuario from tb_perfil_usuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_QRCodes'));