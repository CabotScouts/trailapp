import React, { useEffect, useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { CameraIcon } from '@heroicons/react/solid'
import { Modal, Header } from '@/layouts/modal';
import Errors from '@/components/form/errors';
import PhotoSubmission from '@/components/photo-submission';

export default function Challenge({ challenge, submission }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    challenge: challenge.id,
    photo: null,
  });

  const [doUpload, triggerUpload] = useState(false);

  const triggerFileBrowser = () => {
    const input = document.getElementById('file');
    if (input && !processing) input.click();
  }

  const uploadFile = (e) => {
    setData('photo', e.target.files[0]);
    triggerUpload(true);
  }

  useEffect(() => {
    // force data to update before posting, must be a better way to do this?!
    if (data.photo != null && !processing && doUpload) {
      triggerUpload(false)
      post(route('submit-challenge', challenge.id));
    }
  });

  return (
    <>
      <Head title={challenge.name} />
      <Modal back={route('trail-challenges')}>
        <Header data={challenge} />

        <div className="mb-32">
          {Object.keys(errors).length > 0 &&
            <div className="mx-10 my-0 p-4 bg-white rounded-xl shadow-lg">
              <Errors errors={errors} />
            </div>
          }
          <div className="px-5">
            <PhotoSubmission submission={submission} />
          </div>
        </div>

        <div className="fixed left-0 bottom-0 h-32 w-full">
          {(submission.accepted == false) &&
            <div>
              <form>
                <input
                  type="file"
                  id="file"
                  className="hidden"
                  accept="image/*"
                  onChange={(e) => uploadFile(e)}
                />
              </form>

              <div className={`w-24 mx-auto p-4 rounded-full bg-purple-800 text-center ${processing && 'opacity-25'} cursor-pointer`}>
                <CameraIcon className="text-neutral-100" onClick={triggerFileBrowser} />
              </div>

            </div>
          }
        </div>

      </Modal>
    </>
  );
}
