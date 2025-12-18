import React from 'react';
import { Head } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Global from '@/layouts/global';
import { __ } from '@/composables/translations';

export default function Question({ team, src }) {

  return (
    <Global>
      <Head title={__("Join Team")} />
      <Modal>
        <div className="px-10 py-20 text-white text-xl">
          <div className="pb-5 font-serif text-4xl font-bold">{__("Join a team")}</div>
          <p>{__("join_team_qr", { name: <span className="font-bold">{team}</span> })}</p>
          <div className="pt-10">
            <img className="bg-white rounded-xl shadow-lg mx-auto" src={src} />
          </div>
        </div>
      </Modal>
    </Global >
  );
}
