<ul data-uk-tab>
    <li id="i1"><a href="#">Item1</a></li>
    <li id="i2"><a href="#">Item2</a></li>
    <li id="i3"><a href="#">Item3</a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
    <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
</ul>

<script>
  var util = UIkit.util;
  var tabEl = util.$$('.uk-switcher li')

  // Events list here: https://getuikit.com/docs/switcher#events

  util.on(tabEl, 'show', function(e,active){
    var activeTab = util.$('ul[data-uk-tab] li.uk-active').id;
    UIkit.notification(activeTab);
  });
</script>
