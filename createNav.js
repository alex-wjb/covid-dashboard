const template = document.createElement('template');

template.innerHTML = `
<nav>
  <ul class="nav">
    <!-- closing li omitted to remove inline-block whitespace between els-->
    <li class="navItem"> <a class="navLink" href="index.html">Home</a>
    <li class="navItem"> <a class="navLink" href="Death.html">Deaths Data</a>
    <li class="navItem"> <a class="navLink" href="Testlocation.html">Test Center</a>
    <li class="navItem"> <a class="navLink" href="NHSInformation.html">NHS Information</a>
    
  </ul>
</nav>
`;

document.getElementById("pageTitle").after(template.content);