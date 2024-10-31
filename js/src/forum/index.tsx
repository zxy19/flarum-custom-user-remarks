import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import UserCard from 'flarum/forum/components/UserCard';
import User from 'flarum/common/models/User';
import UserControls from 'flarum/forum/utils/UserControls';
import EditRemarkModal from './EditRemarkModal';
import Button from 'flarum/common/components/Button';
app.initializers.add('xypp/flarum-custom-user-remarks', () => {
  extend(UserCard.prototype, 'infoItems', function (this: UserCard, items) {
    const user: User = (this.attrs as any).user;
    if (user.attribute('realDisplayName')) {
      items.add('remark-real-displayname',
        app.translator.trans('xypp-custom-user-remarks.forum.real_display_name', { n: user.attribute('realDisplayName') })
      );
    }
  });

  extend(UserControls, 'moderationControls', function (items, user) {
    if (app.forum.attribute("can_set_remark")) {
      items.add('set_remark',
        <Button icon="fas fa-user-tag" onclick={() => {
          app.modal.show(EditRemarkModal, { user }, true);
        }}>
          {app.translator.trans('xypp-custom-user-remarks.forum.' + (user.attribute('remark') ? 'edit_remark' : 'set_remark'))}
        </Button>);
    }
  });
});
