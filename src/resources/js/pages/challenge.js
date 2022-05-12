import React from 'react';
import Submit from '@/layouts/submit';
import ValidationErrors from '@/components/validationerrors';
import { Head, useForm } from '@inertiajs/inertia-react';
import { CameraIcon } from '@heroicons/react/solid'

export default function Challenge({ challenge, submission }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    photo: '',
  });

  const triggerFileBrowser = () => {
    const input = document.getElementById('file');
    if(input) input.click();
  }

  const uploadFile = (e) => {
    setData('photo', e.target.files[0]);
    post(route('submit-challenge'));
  }

  return (
    <>
      <Head title={ challenge.name } />
      <Submit>
        <div className="flex-grow flex flex-col">
          <div className="flex-none p-10 pb-0 text-neutral-50">
            <div className="font-serif text-4xl font-bold">{ challenge.name }</div>
            <div className="text-neutral-100">{ challenge.points } points</div>
            <div className="text-lg font-medium mt-5">{ challenge.description }</div>
          </div>

          <div className="flex-grow flex items-center px-10 py-5">
            <div className="flex-grow bg-white rounded-xl shadow-lg overflow-auto">
              <p>submission</p>
            </div>
          </div>

          <div className="flex-none pb-10">
            <ValidationErrors errors={errors} />

            <div className="w-1/4 mx-auto rounded-full bg-purple-800">
              <CameraIcon className="w-full p-3 text-neutral-100" onClick={ triggerFileBrowser }/>
            </div>
          </div>
        </div>
      </Submit>

      <form>
        <input
          type="file"
          id="file"
          className="hidden"
          accept="image/png image/jpeg"
          onChange={ (e) => uploadFile(e) }
        />
      </form>
    </>
  );

}
