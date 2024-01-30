CREATE TABLE rol (
    rol_id INT AUTO_INCREMENT PRIMARY KEY,
    rol_nombre VARCHAR(50),
    rol_situacion SMALLINT DEFAULT 1
);

CREATE TABLE psi_test (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    test_nombre VARCHAR(50),
    test_situacion SMALLINT DEFAULT 1
);

-- CREATE TABLE usuario (
--     usu_id INT AUTO_INCREMENT PRIMARY KEY,
--     usu_nombre VARCHAR(50) UNIQUE,
--     usu_dpi INT UNIQUE,
--     usu_password VARCHAR(255),
--     usu_email VARCHAR(255) UNIQUE,
--     usu_telefono VARCHAR(15),
--     usu_rol INT,
--     usu_situacion SMALLINT DEFAULT 1,
--     FOREIGN KEY (usu_rol) REFERENCES rol(rol_id)
-- );

CREATE TABLE usuario (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_nombre VARCHAR(50) UNIQUE,
    usu_dpi BIGINT UNIQUE,
    usu_password VARCHAR(255),
    usu_email VARCHAR(255) UNIQUE,
    usu_telefono VARCHAR(15),
    usu_rol INT,
    usu_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (usu_rol) REFERENCES rol(rol_id)
);


CREATE TABLE psi_candidato (
    cand_id INT AUTO_INCREMENT PRIMARY KEY,
    cand_dpi  BIGINT UNIQUE,
    cand_primer_nombre VARCHAR(50),
    cand_segundo_nombre VARCHAR(50),
    cand_primer_apellido VARCHAR(50),
    cand_segundo_apellido VARCHAR(50),
    cand_sexo VARCHAR(1),
    cand_fecha_nacimiento DATE,
    cand_fecha_evaluacion DATE DEFAULT CURRENT_DATE,
    cand_fecha_evaluacion_terminada DATE,
    cand_time TIME,
    cand_centro VARCHAR(15) DEFAULT 'ETMA',
    cand_estado varchar(250),
    cand_conclusion VARCHAR(30) DEFAULT 'PENDIENTE',
    cand_test_id INT,
    cand_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (cand_test_id) REFERENCES psi_test(test_id)
);



CREATE TABLE psi_preguntas_epqa (
    pregunta_id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_pregunta VARCHAR(255),
    pregunta_tipo VARCHAR(10),
    pregunta_respuesta INT,
    pregunta_situacion SMALLINT DEFAULT 1,
    pregunta_test_id INT,
    FOREIGN KEY (pregunta_test_id) REFERENCES psi_test(test_id)
);

CREATE TABLE psi_preguntas_iac (
    pregunta_id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_pregunta VARCHAR(255),
    pregunta_tipo VARCHAR(10),
    pregunta_respuesta INT,
    pregunta_situacion SMALLINT DEFAULT 1,
    pregunta_test_id INT,
    FOREIGN KEY (pregunta_test_id) REFERENCES psi_test(test_id)
);

CREATE TABLE psi_respuestas (
    res_id INT AUTO_INCREMENT PRIMARY KEY,
    res_cand_id INT,
    res_test_id INT,
    res_pregunta_id INT,
    res_respuesta INT,
    res_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (res_cand_id) REFERENCES psi_candidato(cand_id),
    FOREIGN KEY (res_test_id) REFERENCES psi_test(test_id),
    FOREIGN KEY (res_pregunta_id) REFERENCES psi_preguntas_epqa(pregunta_id) -- O psi_preguntas_iac dependiendo de la tabla de origen
);

CREATE TABLE psi_baremos_epqa (
    bare_id INT AUTO_INCREMENT PRIMARY KEY,
    bare_sexo VARCHAR(1),
    bare_percentiles INT,
    bare_n INT,
    bare_e INT,
    bare_p INT,
    bare_s INT,
    bare_test_id INT,
    bare_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (bare_test_id) REFERENCES psi_test(test_id)
);

CREATE TABLE psi_baremos_iac (
    pd_id INT AUTO_INCREMENT PRIMARY KEY,
    pd_pc INT,
    pd_personal INT,
    pd_familiar INT,
    pd_escolar INT,
    pd_social INT,
    pd_global INT,
    pd_s INT,
    pd_test_id INT,
    pd_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (pd_test_id) REFERENCES psi_test(test_id)
);

INSERT INTO `psi_test` (`test_id`, `test_nombre`, `test_situacion`) VALUES
(1, 'EPQ-A', 1),
(2, 'IAC', 1),
(3, 'QAP', 1);


INSERT INTO `rol` (`rol_id`, `rol_nombre`, `rol_situacion`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'CANDIDATOS', 1);