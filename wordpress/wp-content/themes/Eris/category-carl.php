<?php
/**
 * @package WordPress
 * @subpackage White Label
 */

get_template_part('parts/header');

loop();

?>
  
  <section class="span8 featured_members">
    <h2 class="span12">Featured Team Members</h2>
<?php
  $i = 0;
  while ( $i < 3 ):
?>
    <section class="span4">
      <div class="member clearfix">
        <div class="badge">
          <img src="<?php echo get_template_directory_uri() ?>/assets/img/zzexpert.jpg" alt="Team Player" title="Team Player" />
          <h4>Associate</h4>
          <div class="badgebottom">&nbsp;</div>
        </div>
        <article>
          <h4><a href="#">screenname</a></h4>
          <address>Chicago, IL</address>
          <h5>Specializes in</h5>
          <ul>
            <li><a href="#">Cat <?php echo ( $i * 2 + 1); ?></a></li>
            <li><a href="#">Cat <?php echo ( $i * 2 + 2); ?></a></li>
          </ul>
        </article>
        <article class="stats">
          <p>Last posted on <time datetime="2011-09-28" pubdate="pubdate">Sep 28, 2011</time>.</p>
          <ul>
            <li>8 answers</li>
            <li>6 blog posts</li>
            <li>4 comments</li>
          </ul>
        </article>
      </div>
    </section>
<?php
  $i++;
  endwhile;
?>
  </section>
  
  <section class="span4 featured_members">
<?php
  $i = 0;
  while ( $i < 3 ):
?>
    <section class="span4">
      <div class="member clearfix">
        <div class="badge">
          <img src="<?php echo get_template_directory_uri() ?>/assets/img/zzexpert.jpg" alt="Team Player" title="Team Player" />
          <h4>Associate</h4>
          <div class="badgebottom">&nbsp;</div>
        </div>
        <article>
          <h4><a href="#">screenname</a></h4>
          <address>Chicago, IL</address>
          <h5>Specializes in</h5>
          <ul>
            <li><a href="#">Cat 1</a></li>
            <li><a href="#">Cat 2</a></li>
          </ul>
        </article>
        <article class="stats">
          <p>Last posted on <time datetime="2011-09-28" pubdate="pubdate">Sep 28, 2011</time>.</p>
          <ul>
            <li>8 answers</li>
            <li>6 blog posts</li>
            <li>4 comments</li>
          </ul>
        </article>
      </div>
    </section>
<?php
  $i++;
  endwhile;
?>
  </section>

<?php

get_template_part('parts/footer');