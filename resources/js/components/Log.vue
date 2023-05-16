<template>
  <span  v-if="logs.length>0">
  <div class="card-sub-header">
    <span class="card-sub-title">操作日志</span>
  </div>
  <div class="card-body">
    <div v-for="log in logs " class="h6 gray mb1">
      [ {{log.create_time}} ] &nbsp;&nbsp;&nbsp;&nbsp; {{ log.creator_name}} &nbsp;&nbsp;&nbsp;&nbsp; <span class="green">{{log.log_type}}</span> &nbsp;&nbsp;&nbsp;&nbsp; <span v-if="log.log_content">备注：{{log.log_content}}</span>
    </div>
  </div>
 </span>
</template>

<script>

export default {
  name: "log",
  props: ['logs'],
}
</script>

<style scoped>
.green{
  color: #2ecc40;
}
.gray {
  color: #aaa;
  font-size: 14px;
}
.mb1 {
  margin-bottom: 2px;
}
</style>
