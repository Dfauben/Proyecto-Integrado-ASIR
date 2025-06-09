# DOCUMENTACIÓN PROYECTO INTEGRADO – ASIR

## 1. INTRODUCCIÓN

Este proyecto tiene como objetivo demostrar la implementación de un sistema CI/CD (Integración y Despliegue Continuo) usando **GitHub Actions**, **Ansible**, **Docker** y **Kubernetes**. En lugar de centrarse en el desarrollo de una aplicación concreta, se pone el foco en automatizar su ciclo de vida completo: desde el control de versiones hasta su despliegue en clientes remotos, simulando un entorno profesional.

Podrá encontrar la documentación sobre la apliación en el siguiente enlace: 

- [Documentación Aplicación PHP](https://github.com/Dfauben/CI-CD-Simulacion-PHP)

<br>

El trabajo ha sido desarrollado como parte del **Proyecto Integrado** del segundo curso del Ciclo Formativo de Grado Superior en **Administración de Sistemas Informáticos en Red (ASIR)** en el IES La Marisma.

## 2. PLANIFICACIÓN

- **Inicio**: Abril 2025  
- **Fin estimado**: Junio 2025  
- **Duración total**: 4 meses  

### Fases:
- Análisis de requisitos
- Preparación de la infraestructura CI/CD
- Desarrollo del pipeline GitHub Actions
- Automatización del despliegue con Ansible
- Contenerización con Docker
- Orquestación con Kubernetes
- Validación funcional
- Redacción de la documentación

## 3. ANÁLISIS

Se parte de una arquitectura sin automatización, donde los despliegues son manuales. Esto implica riesgos de inconsistencia, errores humanos y dificultad para escalar. El proyecto propone una solución automatizada y trazable usando prácticas DevOps.

### Requisitos funcionales:

- Despliegue automático de aplicación PHP (agenda de contactos con JSON)
- Orquestación con Kubernetes en clientes Ubuntu
- Automatización del entorno y servicios con Ansible
- Pipeline de CI/CD completo con GitHub Actions

### Requisitos no funcionales:

- Escalabilidad en clientes
- Modularidad del código y despliegues

## 4. DISEÑO

### Infraestructura:

- Repositorio GitHub centralizado
- Servidor Ubuntu CI/CD (Ansible + SSH)
- Cliente(s) Ubuntu con Kubernetes (minikube)
- Despliegue remoto de contenedores Docker

### Tecnologías:

- GitHub Actions
- Ansible
- Docker
- Kubernetes (minikube)
- Ubuntu Server 22.04
- PHP + JSON

### Arquitectura lógica:

```plaintext
GitHub (PR) 
  ↓
Servidor CI/CD (GitHub Actions → Ansible)
  ↓
Cliente Ubuntu (Kubernetes) 
  → Contenedor App PHP (JSON)
```

## 5. IMPLEMENTACIÓN

### Paso 1: Preparación del entorno

- Configuración del repositorio GitHub y Secrets
- Instalación de Ansible y Docker en el servidor CI/CD
- Acceso SSH entre CI/CD y clientes

### Paso 2: Contenerización de la aplicación PHP

- Dockerfile personalizado
- Configuración de volúmenes para JSON
- Testeo local de la imagen

### Paso 3: Definición de recursos Kubernetes

- deployment.yml para la app
- service.yml para exposición por NodePort

### Paso 4: Automatización con Ansible

- Inventario de clientes
- Playbooks para instalación de Docker y Kubernetes (si no existe)
- Aplicación de manifiestos con kubectl

### Paso 5: Configuración de CI/CD

- deploy.yml en .github/workflows
- GitHub Actions que ejecuta Ansible tras pull request a main

## 6. PRUEBAS

- Acceso a la aplicación desde navegador externo (cliente)
- Validación del funcionamiento del contenedor PHP
- Comprobación de logs y errores
- Simulación de fallos (borrado de pod, reinicio cliente)

## 7. DOCUMENTACIÓN TÉCNICA

- Manual de instalación del entorno
- Manual de uso de Ansible para despliegue
- Ejemplo de flujo CI/CD con capturas
- Diagrama de red y arquitectura

## 8. CONCLUSIONES

Este proyecto demuestra que es posible construir un entorno CI/CD funcional y profesional con herramientas open source. Se ha automatizado por completo el ciclo de vida de una aplicación PHP, desde su integración hasta el despliegue remoto en clientes gestionados con Kubernetes. Esta solución es fácilmente escalable y aplicable a escenarios reales.

## Documentación en formato PDF

[Link al archivo en PDF](./Documentacion_Proyecto_Asir.pdf)

## Anexos

[Anexos](./Anexo/)