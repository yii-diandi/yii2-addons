/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 05:13:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-21 14:02:43
 */

        new Vue({
            el: '#dd-addons-index',
            data: function () {
                return {
                }
            },
            created: function () {
                let that = this;
            },
            methods: {
               dialog(title,url){
                let that = this;
                that.Popup({
                    url:url,
                    title:title,
                    
                    openbefore: () => {
                      // 点击按钮事件
                      console.log('打开前前')
                    }
                  })
        
              }
          }
        })
        