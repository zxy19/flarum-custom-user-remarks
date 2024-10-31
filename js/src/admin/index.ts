import app from 'flarum/admin/app';

app.initializers.add('xypp/flarum-custom-user-remarks', () => {
  app.extensionData.for('xypp-custom-user-remarks')
    .registerPermission({
      icon: 'fas fa-user-tag',
      label: app.translator.trans('xypp-custom-user-remarks.admin.allow_set_remarks'),
      permission: 'set_remark',
    }, 'moderate', 30);
});
