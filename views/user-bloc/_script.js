/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-27 10:01:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-28 01:36:57
 */

new Vue({
    el: '#user-bloc',
    data: {
        title: "打印标题",
        user_id:'',
        user_name:'',
        storelist:[],
        store_names:[],
        userlist:[],
        store_ids:[],
        formLabelAlign:{},
        bloc_id:0,
        store_id:'',
        status:'1',
        dialogStore:false,
        dialogUser:false,
    },
    created:function(){
        let that = this
        that.bloc_id = that.global.getUrlParam('bloc_id')
        console.log('创建开始',that.bloc_id)
        that.init();
    },
    methods: {
        init(){
            let that = this

            that.$http.post('getuser', {bloc_id:that.bloc_id},{
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    'X-CSRF-Token':window.sysinfo.csrfToken // _csrf验证
                }
            }).then((response) => {
                console.log(response.data)
                 //响应成功回调
                if (response.data.code == 200) {
                    that.userlist = response.data.data
                }
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
        },
        getStore(){
            let that = this

            that.$http.post('getstore', {bloc_id:that.bloc_id,user_id:that.user_id},{
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    'X-CSRF-Token':window.sysinfo.csrfToken // _csrf验证
                }
            }).then((response) => {
                console.log(response.data)
                 //响应成功回调
                if (response.data.code == 200) {
                    console.log(response.data.data)
                    that.storelist = response.data.data
                    that.dialogStore= true
                }else{
                    that.$message.error(response.data.message);
                }
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
        },
        StoreDialog(){
            this.getStore()
        },
        UserDialog(){
            this.dialogUser= true
            
        },
        submitForm(formName) {
            let that = this
            that.$http.post('create', {
                    'user_id': that.user_id,
                    'store_id': that.store_ids,
                    'status': that.status,
            }).then((response) => {
              console.log('response',response)
                //响应成功回调
                if (response.data.code == 200) {  
                    console.log(response.data)
                    that.$message({
                        message:response.data.message,
                        type: 'success'
                    });

                    window.location.href = response.data.data.url

                }
            }, (response) => {
                //响应错误回调
                this.$message.error(response.data.message);
                console.log('错误了',response)
            });
            
        },
        resetForm(formName) {
        this.$refs[formName].resetFields();
        },
        handleSelectionChange(val) {
            console.log(val)
            let store_names = []
            let store_ids=[] 
            val.forEach((item,index)=>{
                store_names.push(item.name)
                store_ids.push(item.store_id)
            })
            
            this.store_names = store_names
            this.store_ids = store_ids;
       
        },
        selectUser(index, row) {
                console.log(index, row);
                this.user_id = row.id
                this.user_name = row.username
                this.dialogUser= false
                
        }
    }
});   