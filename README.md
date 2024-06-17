# sismercado
Sistema para mercado

# Configurações servidor
Servidor utilizado: Laragon
- Dentro do arquivo httpd.conf, verificar se a rota está apontando para www ( DocumentRoot "C:/laragon/www" )
- Dentro de <Directory>, ajustar estes parâmetros: Options Indexes FollowSymLinks Includes ExecCGI / AllowOverride All / Require all granted / DirectoryIndex index.php
- Após instalação, acessar via localhost
  
# Configurações banco de dados
Banco utilizado: Sql Server
- As definições do host: 'localhost\SQLEXPRESS'
- Name, user e pass é vazio
- Instalar as tabelas conforme arquivo bd_mercado.sql


