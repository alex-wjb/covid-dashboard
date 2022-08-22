const template = document.createElement('template');

template.innerHTML = `
<nav>
  <ul class="nav">
    <!-- closing li omitted to remove inline-block whitespace between els-->
    <li class="navItem"> <a class="navLink" href="index.html">Home</a>
    <li class="navItem"> <a class="navLink" href="death.html">Deaths Data</a>
    <li class="navItem"> <a class="navLink" href="test-location.html">Test Center</a>
    <li class="navItem"> <a class="navLink" href="nhs-info.html">NHS Information</a>
    
  </ul>
</nav>
`;

document.getElementById("pageTitle").after(template.content);