# **Cocoma-App | Estimador de Proyectos de Software**

**Cocoma-App** es una aplicación web desarrollada en Laravel para la estimación de costos, esfuerzo y tiempo en proyectos de software, utilizando el modelo **COCOMO I** en sus modos Básico e Intermedio. La herramienta permite a los gestores de proyectos y desarrolladores realizar estimaciones precisas, analizar el impacto de diferentes factores de costo y generar informes profesionales.

## **✨ Características Principales**

* **Estimación Dual:** Soporte para los modelos COCOMO Básico e Intermedio.  
* **Análisis de Sensibilidad:** Interfaz dinámica con los 15 "Cost Drivers" (Factores de Costo) del modelo intermedio para un análisis "what-if" en tiempo real.  
* **Cálculos Calibrados:** El motor de cálculo ha sido ajustado finamente para replicar los resultados de los casos de prueba estándar de COCOMO.  
* **Gestión de Proyectos:** Los usuarios pueden crear, guardar y gestionar sus propios proyectos de estimación.  
* **Comparador de Proyectos:** Herramienta visual para comparar las métricas clave de múltiples proyectos a la vez.  
* **Generación de Informes PDF:** Creación de informes profesionales y personalizables con:  
  * Logotipo y fondo de página personalizados.  
  * Resumen del proyecto y resultados finales.  
  * Análisis detallado de los factores de costo.  
  * Tabla comparativa de modos (Orgánico, Semi-acoplado, Empotrado).  
* **Interfaz Moderna:** Desarrollada con una interfaz de usuario reactiva y amigable.

## **🛠️ Tecnologías Utilizadas**

* **Backend:** Laravel 12  
* **Frontend:** Blade, Tailwind CSS  
* **Reactividad:** Livewire 3 y Alpine.js  
* **Generación de PDF:** barryvdh/laravel-dompdf  
* **Autenticación:** Laravel Breeze

## **🚀 Guía de Instalación y Puesta en Marcha**

Para instalar y ejecutar este proyecto en tu entorno local, sigue estos pasos:

1. **Clonar el Repositorio**  
   git clone https://github.com/FabricioNicolasDuarte/Cocoma-App.git
   cd cocoma-app

2. **Instalar Dependencias de PHP**  
   composer install

3. Configurar el Entorno  
   Copia el archivo de ejemplo y crea tu propio archivo de entorno.  
   cp .env.example .env

   Luego, abre el archivo .env y configura tus variables, especialmente la conexión a la base de datos (DB\_\*) y el nombre de la aplicación.  
   APP\_NAME="Cocoma-App"  
   DB\_CONNECTION=mysql  
   DB\_HOST=127.0.0.1  
   DB\_PORT=3306  
   DB\_DATABASE=cocoma\_db  
   DB\_USERNAME=root  
   DB\_PASSWORD=

4. Generar la Clave de la Aplicación  
   Este es un paso crucial para la seguridad de Laravel.  
   php artisan key:generate

5. Ejecutar las Migraciones de la Base de Datos  
   Esto creará todas las tablas necesarias en tu base de datos.  
   php artisan migrate

6. **Iniciar el Servidor de Desarrollo**  
   php artisan serve

¡Y listo\! Ahora puedes acceder a la aplicación en tu navegador visitando http://127.0.0.1:8000.

## **📄 Uso de la Aplicación**

1. **Regístrate** para crear una nueva cuenta de usuario.  
2. Ve a la sección **"Mis Proyectos"** y haz clic en **"Crear Nuevo Proyecto"**.  
3. Rellena los datos iniciales (nombre, KLOC, salario, modo y modelo).  
4. Si eliges el modelo **Intermedio**, ajusta los 15 factores de costo según las características de tu proyecto.  
5. Una vez guardado, podrás acceder a los **detalles del proyecto**, donde verás los cálculos en tiempo real mientras ajustas los parámetros.  
6. Utiliza el botón **"Generar Informe (PDF)"** para obtener un documento profesional con la estimación detallada.  
7. Ve a la sección **"Compare"** para seleccionar varios proyectos y comparar sus métricas clave lado a lado.

## **🤝 Contribuciones**

Las contribuciones son bienvenidas. Si deseas mejorar la aplicación, por favor, sigue estos pasos:

1. Haz un "Fork" del repositorio.  
2. Crea una nueva rama (git checkout \-b feature/nueva-funcionalidad).  
3. Realiza tus cambios y haz "commit" de ellos (git commit \-m 'Añade nueva funcionalidad').  
4. Sube tus cambios a tu rama (git push origin feature/nueva-funcionalidad).  
5. Abre un "Pull Request".

## **📜 Licencia**

Este proyecto está bajo la Licencia MIT. Consulta el archivo LICENSE.md para más detalles.
