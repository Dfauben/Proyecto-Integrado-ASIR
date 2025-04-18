
![](/img/_bannerD.png#gh-dark-mode-only)
![](/img/_bannerL.png#gh-light-mode-only)

---

# Proyecto ASIR – Despliegue Automatizado con Docker y Ansible

## Documentos

- [Anteproyecto](./Anteproyecto/README.md)
- [Documentación del TFG](./TFG/README.md)


## Descripción

Este proyecto tiene como objetivo demostrar la automatización y despliegue de servicios utilizando **Docker** y **Ansible** en un entorno simulado mediante **Proxmox**. El sistema permite gestionar aplicaciones de manera escalable, reproducible y segura, integrando herramientas modernas de DevOps como **Nginx**, **MySQL** y orquestación con **Docker Compose** o **Kubernetes**.

El trabajo ha sido desarrollado como parte del **Proyecto Integrado** del segundo curso del Ciclo Formativo de Grado Superior en **Administración de Sistemas Informáticos en Red (ASIR)** en el IES La Marisma.

## Tecnologías utilizadas

- **Docker**: Contenedorización de servicios.
- **Docker Compose / Kubernetes**: Orquestación de contenedores.
- **Ansible**: Automatización de configuración y despliegue.
- **Nginx**: Proxy reverso para la gestión de tráfico y seguridad.
- **MySQL**: Sistema de gestión de bases de datos relacional.
- **Ubuntu Server 22.04**: Sistema operativo base.
- **Proxmox VE**: Plataforma de virtualización para la simulación del entorno.

## Estructura del proyecto

```bash
proyecto-asir/
├── ansible/
│   ├── playbooks/
│   └── inventory/
├── docker/
│   └── docker-compose.yml
├── nginx/
│   └── default.conf
├── db/
│   └── init.sql
├── README.md
└── documentacion/
    └── Documentacion_Proyecto_Asir.md
```

## Objetivos

- Implementar un sistema de despliegue automatizado en entorno Linux.
- Utilizar Ansible para gestionar servidores y contenedores Docker.
- Asegurar la escalabilidad y portabilidad del sistema.
- Documentar el proceso de diseño, pruebas y despliegue de forma detallada.

## Requisitos

- Proxmox VE (para virtualización).
- Máquina anfitriona con al menos 16 GB de RAM.
- Conexión a internet para instalación de paquetes.
- Conocimientos básicos de redes, sistemas operativos y administración de servicios.

## Licencia

Este proyecto utiliza software de código abierto. El uso comercial de herramientas como **Docker Business**, **MySQL Enterprise** o **Nginx Plus** puede requerir licencias adicionales si se utiliza en entornos productivos con fines de lucro.

## Autor

**David Faustino Benítez**  
2º ASIR – IES La Marisma  
Curso 2024/2025
