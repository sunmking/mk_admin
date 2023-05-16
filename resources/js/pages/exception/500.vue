<template>
  <el-row>
    <el-col>
      <el-result class="mt-1" icon="warning" status="500" title="500" sub-title="对不起, 服务器好像开小差了.">
        <template #extra>
          <el-button type="primary" @click="toHome" size="small">
            首页
          </el-button>
          <el-button type="primary" @click="goBack" size="small">
            重试
          </el-button>
        </template>
      </el-result>
    </el-col>
  </el-row>
</template>

<script>
  export default {
    name: 'Exception500',
    methods: {
      toHome () {
        this.$router.push({ path: '/' })
      },
      goBack () {
        this.$router.go(-1)
      }
    }
  }
</script>
