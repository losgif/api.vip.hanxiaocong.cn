<template>
  <div>
    <el-menu
      :default-active="activeIndex"
      class="el-menu-demo"
      mode="horizontal"
      @select="handleSelect"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#ffd04b">
        <el-menu-item index="1"><router-link to="/">用户信息管理</router-link></el-menu-item>
        <el-menu-item index="2"><router-link to="school">站点管理</router-link></el-menu-item>
        <el-menu-item index="3"><router-link to="user">管理员列表</router-link></el-menu-item>
        <el-submenu index="4" class="pull-right">
        <template slot="title">管理员</template>
        <el-menu-item index="2-1" @click="logout">
            退出登录
        </el-menu-item>
      </el-submenu>
    </el-menu>
    <el-card>
      <el-form ref="form" :model="form" label-width="80px">
        <el-form-item label="站点名称">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">立即创建</el-button>
          <el-button @click="goBack()">返回</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      activeIndex: "2",
      form: {
        name: '',
      }
    }
  },
  methods: {
    onSubmit() {
      axios.post("/school/add", this.form).then(res => {
        if (res.data.errorCode == 0) {
          alert('添加成功')
        } else {
          alert(res.data.errorMsg)
        }
      }).catch(error => {
        console.log(error)
      });
    },
    goBack() {
      history.back()
    },
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
    logout() {
      axios.post("/logout").then(res => {
        location.href = "/login";
      });
    },
  }
}
</script>
<style>
.pull-right {
  float: right !important;
}
</style>