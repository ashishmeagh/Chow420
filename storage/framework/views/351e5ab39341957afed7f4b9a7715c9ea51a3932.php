<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/')); ?>/assets/images/faviconnew.ico">
      <title>Email Template View : <?php echo e(config('app.project.name')); ?></title>
   </head>
   <body style="background:#f1f1f1; margin:0px; padding:0px; font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:21px; color:#666; text-align:justify;">
      <div style="max-width:630px;width:100%;margin:0 auto;">
         <div style="padding:0px 15px;">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td bgcolor="#FFFFFF" style="padding:15px; border:1px solid #e5e5e5;">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                           <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td>
                                       <?php if(isset($site_setting_arr['site_logo'])): ?>
                                       <a href="<?php echo e(url('/')); ?>"><img style="width: 15%;" src="<?php echo e(url('/')); ?>/uploads/profile_image/<?php echo e($site_setting_arr['site_logo']); ?>"  alt="logo" ></a>
                                       <?php endif; ?>
                                    </td>
                                    <td align="right" style="font-size:13px; font-weight:bold;"><?php echo e(date('d-M-Y')); ?></td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td height="10"></td>
                        </tr>
                        <tr>
                           <td  height="1" bgcolor="#ddd"></td>
                        </tr>
                        <tr>
                           <td  height="10"></td>
                        </tr>
                        <tr>
                           <td>
                              <?php echo $content; ?>

                           </td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td height="2" bgcolor="#3f3f3f"></td>
                        </tr>
                        <tr>
                           <td height="10" style="background-color:#2a2a2a;"></td>
                        </tr>
                        <tr>
                           <td style="text-align:center; color:#fff;background-color:#2a2a2a; padding-bottom:10px;"> Copyright <?php echo e(date("Y")); ?> by <a target="_blank" href="<?php echo e(url('/')); ?>" style="text-align:center; color:#fff;"><?php echo e(strtolower(config('app.project.name'))); ?></a> All Right Reserved.
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
               </tr>
            </table>
         </div>
      </div>
   </body>
</html>