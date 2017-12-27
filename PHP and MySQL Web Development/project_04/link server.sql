-- SQL Server 远程链接 MySQL 服务器
exec sp_addlinkedserver 
 @server='edb_interface',  --ODBC里面的data source name
 @srvproduct='edb',
 @provider='MSDASQL',    --这是固定的
 @datasrc='edb_interface',
 @location=NULL,
 @provstr='DRIVER={MySQL ODBC 5.2w Driver};SERVER=172.16.2.3;DATABASE=edb;UID=test;PORT=3306;',
 @catalog = NULL

exec sp_addlinkedsrvlogin 
  @rmtsrvname='edb_interface',
  @useself='false',
  @rmtuser='test',
  @rmtpassword='888888';
  
 
 
select * from openquery(edb_interface, 'select * from ea01')