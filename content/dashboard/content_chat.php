<main class="chat_main container-fluid">
  <h2>Messagerie</h2>
  <header id="chat_mobile">
    <span class="chat_mobile_link" id="msg_from_admin">Important</span>
    <span class="chat_mobile_link" id="msg_in">Recu</span>
    <span class="chat_mobile_link" id="msg_out">Envoyé</span>
    <span class="chat_mobile_link" id="msg_draft">Brouillon</span>
    <span class="chat_mobile_link" id="msg_new">Ecrire</span>
  </header>

  <main>
    <div id="chat_largescreen">
      <span class="chat_link" id="msg_from_admin">Important</span>
      <span  class="chat_link" id="msg_in">Recu</span>
      <span class="chat_link" id="msg_out">Envoyé</span>
      <span class="chat_link" id="msg_draft">Brouillon</span>
      <span class="chat_link" id="msg_new">Ecrire</span>
    </div>
    <div id="chat_seemore">
      <?php chat_generate_seemore(); ?>
    </div>
    <div id="chat_body">
      <?php chat_generate_body(1); ?>
    </div>
  </main>
</main>
