<template>
  <div class="user-layout-wrapper">
    <div class="container">
      <router-view></router-view>
      <div class="footer">
        <div class="copyright">
          Copyright &copy;  {{date_y}} 山东数字农业 版权所有
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Layout',
  data(){
    return {
      date_y: (new Date()).getFullYear()
    }
  },
  mounted () {
    document.body.classList.add('userLayout')
  },
  beforeUnmount () {
    document.body.classList.remove('userLayout')
  }
}
</script>

<style lang="less" scoped>
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  text-align: center;
  margin-bottom: 15px;
  color: #fff;

  .copyright {
    color: #555;
    font-size: 14px;
  }
}
</style>
