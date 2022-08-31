<template>
  <div id="app">
    <div class="head-nav">
      <a class="sage" href="https://www.sage.com/fr-fr/" target="_blank">Sage</a>
      <!-- <a class="home" href="">Home</a> -->
    </div>

    <router-view/>
  </div>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}


.head-nav{
  background-color: rgb(84, 84, 223);
  padding: 4px;
  width: 100%;
  display: flex;
align-items: center;
 
}
.head-nav .home{
  background: none;
  border: none;
  color:white;
  text-align: center;
  // font-weight: bold;
  margin-left:5% ;
  font-size: 14pt;
  text-decoration: none;
}
.head-nav .home:active{
  color: rgb(115, 255, 0);
}
.head-nav .sage{
  margin-left: 5%;
  font-size: 25pt;
    color:rgb(187, 255, 0);
  font-weight:bold;
  text-decoration: none;
}
.head-nav .sage:hover{
color:greenyellow;
}
nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>

