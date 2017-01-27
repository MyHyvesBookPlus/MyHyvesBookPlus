<div class="content">
    <div class="profile-box platform">
        <img class="left group-picture" src="<?= $group['picture'] ?>">
        <div class="profile-button">
            <p><img src="img/leave-group.png"> Groep verlaten</p>
        </div>
        <h1 class="profile-username"><?= $group['name'] ?></h1>
        <p><?= $group['description'] ?></p>
    </div>

    <div class="item-box-full-width platform">
        <h2>Leden (<?= $group['members'] ?>)</h2>
        <p>
            <?php
                foreach($members as $member) {
                    echo "<a href=\"profile.php?username=" . $member["username"] . "\" data-title=\"" . $member["username"] . "\"><img class=\"profile-picture\" src=\"" . $member["profilepicture"] . "\" alt=\"" . $member["username"] . "'s profielfoto\">";
                }
            ?>
        </p>
    </div>

    <div class="posts">
        <div class="post platform">
            <h2>Lorem</h2>
            <p>Lorem ipsum dolor sit amet, consectetur.</p>
            <p class="subscript">Enkele minuten geleden geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Image</h2>
            <img src="http://i.imgur.com/ypIQKjE.jpg" alt="Olympic Mountains, Washington">
            <p class="subscript">Gisteren geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Ipsum</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem nihil alias amet dolores fuga totam sequi a cupiditate ipsa voluptas id facilis nobis.</p>
            <p class="subscript">Maandag geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Sit</h2>
            <p>Lorem ipsum dolor sit.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Image</h2>
            <img src="https://i.redditmedia.com/EBWWiEojgkRrdn89R7qF7tBZjJszJaIqgkWUH23s11A.jpg?w=576&s=ba4fe1f02485cb2327305924ef869a66" alt="Nunobiki Falls, Kobe Japan">
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Amet</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima asperiores eveniet vero velit eligendi aliquid in.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Consectetur</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error aliquid reprehenderit expedita odio beatae est.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Adipisicing</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat architecto quis tenetur fugiat veniam iste molestiae fuga labore!</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Elit</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem ut debitis dolorum earum expedita eveniet voluptatem quibusdam facere eos numquam commodi ad iusto laboriosam rerum aliquam.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Geen error</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus dolorem maxime minima animi cum.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Image</h2>
            <img src="https://i.reddituploads.com/82c1c4dd0cfb4a4aa1cfa16f93f5dbfa?fit=max&h=1536&w=1536&s=dd629d407f3646ee6e3adb4da78c93f2" alt="Oregon cliffs are no joke.">
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Aliquid</h2>
            <p>Lorem ipsum dolor sit amet, consectetur.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Odit</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit accusamus tempore at porro officia rerum est impedit ea ipsa tenetur. Labore libero hic error sunt laborum expedita.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
        <div class="post platform">
            <h2>Accusamus</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quaerat suscipit ad.</p>
            <p class="subscript">4 Januari geplaatst</p>
        </div>
    </div>

</div>