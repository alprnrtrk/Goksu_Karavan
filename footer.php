<footer class="relative w-full px-[30px] py-[50px]">
  <div class="w-full h-[50px] flex items-center justify-between px-[30px] border border-white/25 rounded-full">
    <span>
      &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>.
    </span>
    <span>
      Doğru Adrestesiniz
    </span>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>