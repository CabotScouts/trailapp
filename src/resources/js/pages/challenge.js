import React, { useEffect, useState } from 'react';
import Submit from '@/layouts/submit';
import ValidationErrors from '@/components/validationerrors';
import { Head, useForm } from '@inertiajs/inertia-react';
import { CameraIcon } from '@heroicons/react/solid'

export default function Challenge({ challenge, submission }) {

  const [ doUpload, triggerUpload ] = useState(false);

  const { data, setData, post, processing, errors, reset } = useForm({
    photo: null,
  });

  const triggerFileBrowser = () => {
    const input = document.getElementById('file');
    if(input && !processing) input.click();
  }

  const uploadFile = (e) => {
    setData('photo', e.target.files[0]);
    triggerUpload(true);
  }

  useEffect(() => {
    // force data to update before posting, must be a better way to do this?!
    if(data.photo != null && !processing && doUpload) {
      triggerUpload(false)
      post(route('submit-challenge', challenge.id));
    }
  });

  return (
    <>
      <Head title={ challenge.name } />
      <Submit>
        <div className="w-full">
          <div className="p-10 text-neutral-50">
            <div className="pt-5 font-serif text-4xl font-bold">{ challenge.name }</div>
            <div className="text-neutral-100">{ challenge.points } points</div>
            <div className="text-lg font-medium mt-5">{ challenge.description }</div>
          </div>

          <div>
            <div className={`w-24 mx-auto p-4 rounded-full bg-purple-800 text-center${ processing && 'opacity-25'}`}>
              <CameraIcon className="text-neutral-100" onClick={ triggerFileBrowser }/>
            </div>
            { errors && (
              <ValidationErrors errors={ errors } />
            )}
          </div>

          <div className="p-10">
          { submission && (
            <div className="flex-grow overflow-auto">
              <a href={ submission } target="_blank">
                <img className="rounded-xl shadow-lg mx-auto" src={ submission } />
              </a>
            </div>
          )}
          </div>
        </div>
      </Submit>

      <form>
        <input
          type="file"
          id="file"
          className="hidden"
          accept="image/*"
          onChange={ (e) => uploadFile(e) }
        />
      </form>
    </>
  );

}
