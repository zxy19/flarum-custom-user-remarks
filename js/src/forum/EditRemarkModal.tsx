import app from 'flarum/forum/app';
import Modal, { IInternalModalAttrs } from 'flarum/common/components/Modal';
import User from 'flarum/common/models/User';
import Stream from 'flarum/common/utils/Stream';
import Button from 'flarum/common/components/Button';

export default class EditRemarkModal extends Modal<{
    user: User
} & IInternalModalAttrs> {
    private remark: Stream<string>
    oninit(vnode: any) {
        super.oninit(vnode);

        this.remark = Stream(this.attrs.user.data.attributes!['remark'] || "");
    }
    className(): string { return 'Modal Modal--small'; }
    title() {
        if (this.attrs.user.attribute('remark')) {
            return app.translator.trans('xypp-custom-user-remarks.forum.edit_remark');
        }
        return app.translator.trans('xypp-custom-user-remarks.forum.set_remark');
    }
    content() {
        return <div className="Modal-body">
            <div className="Form-group">
                <div className="Form-group">
                    <input className="FormControl" bidi={this.remark} />
                </div>
                <div className="Form-group">
                    <Button className='Button Button--primary' type='submit' loading={this.loading}>
                        {app.translator.trans('xypp-custom-user-remarks.forum.submit_button')}
                    </Button>
                </div>
            </div>
        </div>;
    }

    onsubmit(e: SubmitEvent) {
        e.preventDefault();

        this.loading = true;

        this.attrs.user
            .save({ remark: this.remark() || null }, { errorHandler: this.onerror.bind(this) })
            .then(() => {
                if (this.remark()) {
                    this.attrs.user.pushAttributes({
                        realDisplayName: this.attrs.user.attribute("realDisplayName") || this.attrs.user.displayName(),
                        displayName: this.remark()
                    })
                } else {
                    this.attrs.user.pushAttributes({
                        realDisplayName: null,
                        displayName: this.attrs.user.attribute("realDisplayName") || this.attrs.user.displayName()
                    })
                }
                this.hide();
            })
            .catch(() => {
                this.loading = false;
                m.redraw();
            });
    }
}