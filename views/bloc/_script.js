/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 05:13:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-09 18:41:49
 */

        new Vue({
            el: '#bloc-index',
            data: function () {
                return {
                }
            },
            created: function () {
                let that = this;
                console.log('全局设置是否可以',window.sysinfo)
                console.log('a is: ' + this.DistributionGoods)
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
        