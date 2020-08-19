-- Scripts del Proyecto Base

CREATE TABLE atributo_configuracion
(
    id         INT AUTO_INCREMENT NOT NULL,
    clave      VARCHAR(255)       NOT NULL,
    valor      TEXT               NOT NULL,
    created_at DATETIME           NOT NULL,
    updated_at DATETIME DEFAULT NULL,
    created_by VARCHAR(255)       NOT NULL,
    updated_by VARCHAR(255)       NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE `UTF8_unicode_ci`
  ENGINE = InnoDB;

CREATE TABLE `user`
(
    id                    INT AUTO_INCREMENT NOT NULL,
    username              VARCHAR(180)       NOT NULL,
    username_canonical    VARCHAR(180)       NOT NULL,
    email                 VARCHAR(180)       NOT NULL,
    email_canonical       VARCHAR(180)       NOT NULL,
    enabled               TINYINT(1)         NOT NULL,
    salt                  VARCHAR(255) DEFAULT NULL,
    password              VARCHAR(255)       NOT NULL,
    last_login            DATETIME     DEFAULT NULL,
    confirmation_token    VARCHAR(180) DEFAULT NULL,
    password_requested_at DATETIME     DEFAULT NULL,
    roles                 LONGTEXT           NOT NULL COMMENT '(DC2Type:array)',
    created_at            DATETIME           NOT NULL,
    updated_at            DATETIME     DEFAULT NULL,
    created_by            VARCHAR(255)       NOT NULL,
    updated_by            VARCHAR(255)       NOT NULL,
    UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical),
    UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical),
    UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE `UTF8_unicode_ci`
  ENGINE = InnoDB;

CREATE TABLE provincia
(
    id          INT AUTO_INCREMENT NOT NULL,
    area_numero INT                NOT NULL,
    nombre      VARCHAR(255)       NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE `UTF8_unicode_ci`
  ENGINE = InnoDB;

CREATE TABLE localidad
(
    id             INT AUTO_INCREMENT NOT NULL,
    provincia_id   INT          DEFAULT NULL,
    l_distrito     VARCHAR(3)         NOT NULL,
    l_nom_dis      VARCHAR(150)       NOT NULL,
    l_departamento VARCHAR(3)         NOT NULL,
    l_nom_dpto     VARCHAR(150)       NOT NULL,
    nodo           VARCHAR(250)       NOT NULL,
    email          VARCHAR(150) DEFAULT NULL,
    password       VARCHAR(50)  DEFAULT NULL,
    created_at     DATETIME           NOT NULL,
    updated_at     DATETIME     DEFAULT NULL,
    created_by     VARCHAR(255)       NOT NULL,
    updated_by     VARCHAR(255)       NOT NULL,
    UNIQUE INDEX UNIQ_4F68E010E7927C74 (email),
    INDEX IDX_4F68E0104E7121AF (provincia_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE `UTF8_unicode_ci`
  ENGINE = InnoDB;

ALTER TABLE localidad
    ADD CONSTRAINT FK_4F68E0104E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id);

ALTER TABLE user ADD nombre VARCHAR(100) NOT NULL, ADD apellido VARCHAR(100) NOT NULL, ADD dni INT NOT NULL;

