<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?= "Thông tin liên hệ / Phản hồi từ {$info['name']}"; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="text/css">
      
      table {
          border-spacing: 0px;
          border: 1px solid #cccccc;
      }
      
      table thead tr th {
          font-weight: bold;
          border: 1px solid #ddd;
      }
      
      table td:first-child {
          font-weight: bold;
      }  
      
      table td {
          padding: 5px 5px 5px 5px;
          border: 1px solid #ddd;
      }      
      
  </style>
</head>
    
<body style="margin: 0; padding: 0;">

    <h2>THÔNG TIN LIÊN HỆ / PHẢN HỒI TỪ KHÁCH HÀNG: <span style="font-weight: bold;"><?= $info['name']; ?></span> </h2>
    
    <h3>Thông tin khách hàng</h3>
    
    <table style="width: 500px; border: 1px solid #cccccc;">
     <tr>
         <td style="width:120px;"> <?= 'Tên khách hàng' ?> </td>
        <td> <?= $info['name']; ?> </td>
     </tr>
        
     <tr>
        <td> <?= 'Điện thoại' ?> </td>
        <td> <?= $info['phone']; ?> </td>
     </tr>
        
     <tr>
      <td> <?= 'Email' ?> </td>
      <td> <?= $info['email']; ?> </td>
     </tr>
        
     <tr>
      <td> <?= 'Tiêu đề' ?> </td>
      <td> <?= $info['subject']; ?> </td>
     </tr>
        
     <tr>
      <td> <?= 'Nội dung' ?> </td>
      <td> <?= $info['content']; ?> </td>
     </tr>
        
    </table>    

</body>    
    
</html>