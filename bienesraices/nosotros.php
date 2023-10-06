<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="webp">
                    <source srcset="build/img/nosotros.jpg" type="jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Imagen sobre nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>25 años de experiencia</blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptas dolorum doloribus esse debitis odit iste itaque maxime necessitatibus. Sint autem fuga, impedit dolorem quas sed in aperiam vitae veniam expedita laudantium unde. Nulla quidem ratione qui laudantium delectus, vel tenetur quae obcaecati voluptatibus error.</p>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo ab nihil deserunt doloribus non qui quaerat quidem, aut blanditiis porro praesentium laborum fuga, repellendus ex consequuntur. Vitae perferendis accusamus, ipsum perspiciatis provident iste laudantium quae itaque optio nam voluptates similique beatae quas nulla explicabo sapiente! Quidem rerum, temporibus tempore nisi voluptatibus a vel dolorum. Perferendis, ab. Ab, alias corrupti quas veritatis suscipit, asperiores accusamus eveniet, porro consectetur labore iusto nihil.</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h2>Más sobre nosotros</h2>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi nostrum praesentium labore ab fugiat esse sapiente eum deserunt? Deserunt in similique delectus fugit cumque culpa et porro quos earum blanditiis.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi nostrum praesentium labore ab fugiat esse sapiente eum deserunt? Deserunt in similique delectus fugit cumque culpa et porro quos earum blanditiis.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi nostrum praesentium labore ab fugiat esse sapiente eum deserunt? Deserunt in similique delectus fugit cumque culpa et porro quos earum blanditiis.</p>
            </div>
        </div>
    </section>


<?php 
    incluirTemplate('footer');
?>  