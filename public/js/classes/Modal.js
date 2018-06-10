var Modal = {
  modal: null,
  yesBtn: null,
  noBtn: null,
  body: null,
  onYes: null,
  onHide: null,

  init: function () {
    var me = this;

    this.yesBtn = $('<button>').attr({type: 'button'}).addClass('btn btn-primary').text('დიახ');
    this.noBtn = $('<button>').attr({type: 'button'}).addClass('btn btn-default').attr('data-dismiss', 'modal').text('დახურვა');
    this.body = $('<div>').addClass('modal-header').text('დარწმუნებული ხართ?');

    this.modal = $('<div>').addClass('modal fade').css({ zIndex: 1000000 }).attr({role: 'dialog', 'aria-hidden': 'true'}).append(
      $('<div>').addClass('modal-dialog').append(
        $('<div>').addClass('modal-content').append(
          this.body
        ).append(
          $('<div>').addClass('modal-footer').append(
            this.noBtn
          ).append(
            this.yesBtn
          )
        )
      )
    );

    this.yesBtn.click(function () {
      me.onYes && me.onYes("yes");
    });

    this.modal.on('hidden.bs.modal', function () {
      me.onHide && me.onHide();
    });

    $('body').append(this.modal);
  },

  show: function (cfg) {
    this.yesBtn.text(cfg.yes || 'დიახ');
    this.noBtn.text(cfg.no || 'დახურვა');
    this.body.text(cfg.body || 'დარწმუნებული ხართ?');

    this.yesBtn.css({display: cfg.withoutYes ? 'none' : 'inline-block'})
    this.noBtn.css({display: cfg.withoutNo ? 'none' : 'inline-block'})

    this.onYes = cfg.callback || null;
    this.onHide = cfg.onHide || null;

    this.yesBtn.removeClass('btn-default btn-danger btn-info btn-primary btn-success btn-warning').addClass(cfg.yesClass || 'btn-primary')

    this.modal.modal('show');
  },

  hide: function () {
    this.modal.modal('hide');
  }
};

$(function () {
  Modal.init();
});