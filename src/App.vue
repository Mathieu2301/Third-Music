<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<style>
body {
  background-color: #19222D;
  margin: 0;
  color: #FFF;
}

body * {
  box-sizing: border-box;
  transition-duration: 0.1s;
}

#app {
  font-family: Helvetica, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin-top: 90px;
  margin-bottom: 90px;
}

.noselect * {
  user-select: none;
}

.clickable {
  cursor: pointer;
}

.aplayer {
  position: fixed !important;
  margin: 0 !important;
  width: 100%;
  bottom: 0;
}
</style>
