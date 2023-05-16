<template>
  <el-row>
    <el-col>
      <el-result class="mt-1" icon="error" status="404" title="404" sub-title="对不起, 您访问的页面不存在.">
        <template #extra>
          <el-button type="primary" @click="toHome" size="small">
            返回首页
          </el-button>
        </template>
      </el-result>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: 'Exception404',
  methods: {
    toHome () {
      this.$router.push({ path: '/' })
    }
  }
}
</script>
