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

      <el-table
          :data="infoList"
          border
          max-height="800"
          @selection-change="handleSelectionChange"     
          style="width: 100%">
          <el-table-column
          fixed            
          type="selection"
          width="">
          </el-table-column>
          <el-table-column
          prop="id"
          label="站点ID"
          width="">
          </el-table-column>
          <el-table-column
          prop="name"
          label="站点名称"
          width="">
          </el-table-column>
          <el-table-column 
          label="上传入口"
          width="">
          <template slot-scope="scope">
            {{ origin }}/information/#/goddess/home/{{ scope.row.id }}
          </template>
          </el-table-column>
          <el-table-column
          prop="created_at"
          label="创建时间"
          width="">
          </el-table-column>
          <!-- <el-table-column
          fixed="right"
          label="操作"
          width="">
          <template slot-scope="scope">
              <el-button @click="handleClick(scope.row)" type="text" size="small"><i class="el-icon-delete-solid"></i>删除</el-button>
          </template>
          </el-table-column> -->
      </el-table>

      <div style="margin:20px; text-align:center; ">
          <el-button><router-link to="addSchool">添加站点</router-link></el-button>
      </div>
      
      <el-pagination
      class="text-center"
      background
      layout="prev, pager, next"
      @current-change="handleCurrentChange"
      :current-page="currentPage"
      :page-size="prePage"
      :total="total">
      </el-pagination>
  </div>
</template>

<script>
export default {
  methods: {
    handleClick(row) {
      console.log(row);
      axios.delete("/school?id=" + row.id).then(res => {
        if (res.data.errorCode == 0) {
          alert("删除成功")
        }
      });
    },
    handleSelectionChange(val) {
      this.multipleSelection = {};
      val.forEach((element, index) => {
        this.multipleSelection[index] = element.id;
      });
      this.multipleSelection = JSON.stringify(this.multipleSelection);
    },
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
    logout() {
      axios.post("/logout").then(res => {
        location.href = "/login";
      });
    },
    handleCurrentChange(currentPage) {
      console.log(currentPage);
      axios.get("/school?page=" + currentPage).then(res => {
        if (res.data.errorCode == 0) {
          this.infoList = res.data.errorMsg.data;
          this.total = res.data.errorMsg.total;
          this.prePage = res.data.errorMsg.per_page;
          this.currentPage = res.data.errorMsg.current_page;
          console.log(res.data);
        }
      });
    }
  },

  mounted() {
    this.origin = location.origin
    
    axios.get("/school").then(res => {
      if (res.data.errorCode == 0) {
        this.infoList = res.data.errorMsg.data;
        this.total = res.data.errorMsg.total;
        this.prePage = res.data.errorMsg.per_page;
        this.currentPage = res.data.errorMsg.current_page;
        console.log(this.infoList);
      }
    });
  },

  data() {
    return {
      activeIndex: "2",
      infoList: [],
      page: 0,
      total: 0,
      prePage: 0,
      currentPage: 0,
      multipleSelection: null,
      origin: '',
    };
  }
};
</script>

<style>
.pull-right {
  float: right !important;
}
.el-message-box {
  width: 45%;
  height: 80%;
}
.el-message-box,
.el-message-box__content {
  height: 100%;
}
.el-message-box,
.el-message-box__content,
.el-message-box__message {
  height: 100%;
}
.el-message-box,
.el-message-box__content,
.el-message-box__message,
p {
  height: 92%;
}
</style>
