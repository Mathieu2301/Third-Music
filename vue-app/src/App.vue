<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<style>
body {
  background-color: #0f9b0f;
  margin: 0;
  color: #FFF;
  user-select: none;
  -webkit-tap-highlight-color: transparent;
}

body * {
  box-sizing: border-box;
  transition-duration: 0.1s;
}

#app {
  font-family: Helvetica, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin-top: 70px;
  margin-bottom: 65px;
}

.header {
  display: flex;
  justify-content: space-between;
  position: fixed;
  top: 0;
  height: 70px;
  width: 100%;
  background-color: #1b5e20;
  background: linear-gradient(-15deg,#000,#0f9b0f);
  z-index: 10;
  opacity: 0.8;
  box-shadow: 0 3px 8px #0000002e;
}

.header img {
  opacity: 0.9;
  height: 70px;
}

.header .title {
  color: #4be24b;
  opacity: 0.7;
  font-size: 35px;
  margin: 15px 25px 0;
}

.loading {
  position: fixed;
  fill: #0c2c0c;
  top: calc(45% - 30px);
  left: calc(50% - 30px);
  height: 60px;
  z-index: 0;
}

.clickable { cursor: pointer }

.hideable {
  transition-delay: 0.3s;
  transition-duration: 0.5s;
}

.hidden { opacity: 0 }

.aplayer {
  position: fixed !important;
  margin: 0 !important;
  width: 100%;
  bottom: 0;
}
</style>
