import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import SubmitModal from '@/layouts/submit-modal';
import ModalHeader from '@/components/modal-header';
import PhotoUpload from '@/components/photo-upload';
import PhotoSubmission from '@/components/photo-submission';

export default function Challenge({ challenge, submission }) {
  return (
    <>
      <Head title={ challenge.name } />
      <SubmitModal>
        <ModalHeader data={ challenge } />
        <PhotoUpload target={ route('submit-challenge', challenge.id) } />
        <PhotoSubmission submission={ submission } />
      </SubmitModal>
    </>
  );
}
