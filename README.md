# Proyecto-TFG
Proyecto para el TFG del curso de Administración de Sistemas Informáticos en Red 

## Anteproyecto

_Dpto. Informática - I.E.S. La Marisma C.F.G.S. Administración de Sistemas Informáticos en Red_

### PROPUESTA DE PROYECTO

Nombre del proyecto: Despliegue Automatizado con Docker y Ansible

Alumno: David Faustino Benítez

Curso: 2º

Tutor: Gonzalo Cañadillas Rueda

#### OBJETIVOS

Desarrollar un sistema automatizado para el despliegue y gestión de aplicaciones usando
Docker como tecnología de contenedores y Ansible para la configuración y
automatización del entorno.

El proyecto se realizará mediante Proxmox como plataforma de virtualización,
permitiendo la creación de un entorno de pruebas realista sin necesidad de utilizar
servidores físicos.

#### PREANÁLISIS DEL SISTEMA

- Uso de contenedores para las aplicaciones: Docker gestionará la ejecución de
    servicios en contenedores ligeros y portables.
- Orquestación de contenedores: Kubernetes gestionará los despliegues,
    garantizando alta disponibilidad y escalabilidad.
- Automatización y configuración: Ansible se encargará de la instalación y
    configuración automática del entorno Docker y de los servicios desplegados.
- Gestor de versiones: Se utilizará GitHub para controlar cambios en el proyecto.
- Seguridad y redes: Definición de las políticas de acceso, configuración de redes
    internas entre contenedores y configuraciones de seguridad en Docker.
- Entorno de virtualización para simulación: Proxmox nos permitirá simular la
    implementación del sistema en máquinas virtuales.

#### PREDISEÑO DEL SISTEMA

- Hardware: Servidor con al menos 16 GB de RAM y 200 GB de almacenamiento.
- Sistema Operativo: Ubuntu Server 22.04.


- Software:
    o Proxmox para la simulación del entorno.
    o Docker y Kubernetes para la gestión de contenedores.
    o Ansible para la automatización del despliegue y configuración.
    o Git para el control de versiones.
    o Nginx como proxy reverso.
    o Base de datos MySQL.

Arquitectura del Despliegue

El sistema contará con las siguientes máquinas virtuales dentro de Proxmox:

- Servidor Principal (Ansible Master y Docker Host): Máquina encargada de
    ejecutar Ansible y de alojar los contenedores Docker.
- Máquinas cliente: Las cuales comprobarán el correcto funcionamiento del
    sistema.

#### ESTIMACIÓN DE COSTES

Temporal

- Desarrollo del proyecto: Aproximadamente 2,5 meses.
- Pruebas y validación: 1 mes.
- Documentación: 2 semanas.
- Total estimado: 4 meses.

Económica

El uso de software de código abierto (Docker, Ansible, Git, etc.) hace que las licencias
no nos cuesten dinero.

Servidor: Dell PowerEdge R540 con un costo aproximado de 2.500 - 3.000 €,
dependiendo de la configuración.

Software empresarial opcional:

- Docker Business: Aproximadamente 21 €/usuario/mes.
- Ansible Automation Platform: Precio personalizado según necesidades
    empresariales.
- Nginx Plus: Aproximadamente 2.500 €/año por instancia.
- MySQL Enterprise Edition: Aproximadamente 5.000 €/año por servidor.


Total aproximado: 2.500 - 10.000 €, dependiendo de si se eligen versiones
empresariales del software o versiones de código abierto gratuitas.



[PDF](./Anteproyecto/Anteproyecto_TFG.pdf)

<object data="http://github.com/Dfauben/Proyecto-TFG" type="application/pdf" width="700px" height="700px">
    <embed src="https://github.com/Dfauben/Proyecto-TFG/Anteproyecto/Anteproyecto_TFG.pdf">
        <p>This browser does not support PDFs. Please download the PDF to view it: <a href="[http://yoursite.com/the.pdf](https://github.com/Dfauben/Proyecto-TFG/Anteproyecto/Anteproyecto_TFG.pdf)">Download PDF</a>.</p>
    </embed>
</object>
