-- Cria o banco de dados se ele ainda não existir
CREATE DATABASE IF NOT EXISTS saep_db;
USE saep_db;

-- Cria a tabela produtos se Ela nao existir
CREATE TABLE IF NOT EXISTS produtos (
    idprodutos INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NULL DEFAULT NULL,
    tensaoVoltagem VARCHAR(200) NULL DEFAULT NULL,
    resolucaoTela VARCHAR(200) NULL DEFAULT NULL,
    armazenamento VARCHAR(200) NULL DEFAULT NULL,
    conectividade VARCHAR(150) NULL DEFAULT NULL
);

-- Cria a tabela movimentacao se ela nao existir
CREATE TABLE IF NOT EXISTS movimentacao (
    idmovimentacao INT(10) NOT NULL AUTO_INCREMENT,
    movimentacao VARCHAR(200) NOT NULL,
    produtos_idprodutos INT(11) NOT NULL,
    quantidade VARCHAR(200) NOT NULL,
    PRIMARY KEY (idmovimentacao),
    CONSTRAINT fk_produtos_movimentacao 
    FOREIGN KEY (produtos_idprodutos) 
    REFERENCES produtos(idprodutos)

);


INSERT INTO produtos (
    nome,
    tensaoVoltagem,
    resolucaoTela,
    armazenamento,
    conectividade
    )VALUES (
    'Smartphone XYZ',
    'Bivolt',
    '2340x1080', '128GB', 
    'Wi-Fi, Bluetooth, 5G'
    );

INSERT INTO produtos (
    nome,
    tensaoVoltagem,
    resolucaoTela,
    armazenamento,
    conectividade
    )VALUES(
    'Monitor UltraWide',
    '110v/220v',
    '2560x1080',
    'N/A',
    'HDMI, DisplayPort'
    );

INSERT INTO produtos (
    nome,
    tensaoVoltagem,
    resolucaoTela,
    armazenamento,
    conectividade
    )VALUES(
    'Notebook Gamer',
    'Bivolt',
    '1920x1080',
    '512GB SSD',
    'Wi-Fi 6, Bluetooth 5.2'
    );

    INSERT INTO movimentacao (
   movimentacao,
   produtos_idprodutos,
   quantidade
    )VALUES(
    '1',
     1, 
    '10');


INSERT INTO movimentacao (
   movimentacao,
   produtos_idprodutos,
   quantidade
    )VALUE(
    '2',
    1,
    '5'
    );
INSERT INTO movimentacao (
   movimentacao,
   produtos_idprodutos,
   quantidade
    )VALUE(
    '1',
    2,
    '20'
    );
        
   