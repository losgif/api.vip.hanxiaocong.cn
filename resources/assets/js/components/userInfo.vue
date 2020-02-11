<template>
    <div>

<el-menu
  :default-active="activeIndex2"
  class="el-menu-demo"
  mode="horizontal"
  @select="handleSelect"
  background-color="#545c64"
  text-color="#fff"
  active-text-color="#ffd04b">
  <el-menu-item index="1">用户信息管理</el-menu-item>
  <el-submenu index="2" class="pull-right">
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
            width="60">
            </el-table-column>
            <el-table-column
            prop="id"
            label="Id"
            width="80">
            </el-table-column>
            <el-table-column
            prop="name"
            label="姓名"
            width="80">
            </el-table-column>
            <el-table-column
            prop="sex"
            label="性别"
            width="80">
            </el-table-column>
            <el-table-column
            prop="ta_tel"
            label="Ta的联系方式"
            width="120">
            </el-table-column>
            <el-table-column
            prop="my_tel"
            label="我的联系方式"
            width="120">
            </el-table-column>
            <el-table-column
            prop="height"
            label="身高"
            width="80">
            </el-table-column>
            <el-table-column
            prop="brith_place"
            label="出生地"
            width="80">
            </el-table-column>
            <el-table-column
            prop="detail"
            label="爆料"
            width="300">
            </el-table-column>
            <el-table-column
            prop="expect"
            label="期望"
            width="300">
            </el-table-column>
            <el-table-column 
            label="图片"
            width="300">
            <template scope="scope">
                <img :src="scope.row.upload_url" class="upload_url" width="100%" height="120"/>
            </template>
            </el-table-column>
            <el-table-column
            prop="created_at"
            label="创建时间"
            width="160">
            </el-table-column>

            <!-- <el-table-column
            fixed="right"
            label="操作"
            width="100">
            <template slot-scope="scope">
                <el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button>
                <el-button type="text" size="small">编辑</el-button>
            </template>
            </el-table-column> -->
        </el-table>

        <div style="margin:20px; text-align:center; ">
            <el-button @click="open">样式生成</el-button>
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
    },
    open() {
      var url =
        '<iframe src="/open?array=' +
        encodeURI(this.multipleSelection) +
        '" height="100%" width="100%" frameborder=0></iframe>';
      this.$alert(url, "HTML 片段", {
        dangerouslyUseHTMLString: true,
        title: "",
        showClose: false,
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: "关闭"
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
      axios.post("/getAllInfo?page=" + currentPage).then(res => {
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
    axios.post("/getAllInfo").then(res => {
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
      activeIndex: "1",
      activeIndex2: "1",
      infoList: [],
      page: 0,
      total: 0,
      prePage: 0,
      currentPage: 0,
      multipleSelection: null
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
