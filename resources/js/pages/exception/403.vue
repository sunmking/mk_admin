<template>
  <div class="card-warp">
    <div class="card-bord">
      <el-row>
        <el-col>
          <el-result class="mt-1" icon="error" status="403" title="403" sub-title="对不起, 你没有访问该页面的权限.">
            <template #extra>
              <el-button type="primary" @click="toHome" size="small">
                首页
              </el-button>
              <el-button type="primary" @click="goBack" size="small">
                返回
              </el-button>
            </template>
          </el-result>
        </el-col>
      </el-row>
    </div>
  </div>

</template>

<script>
export default {
  name: 'Exception403',
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
